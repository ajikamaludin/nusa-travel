import React, { useEffect, Suspense, useState } from 'react'
import { isEmpty } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import { Head, useForm } from '@inertiajs/react'
import FormInput from '@/Components/FormInput'
import Checkbox from '@/Components/Checkbox'
import ProductSelectionInput from './SelectionInput'
import PlaseSelectionInput from '../FastboatPlace/SelectionInput'
import FormInputTime from '@/Components/FormInputTime'
import axios from 'axios'
import { Spinner } from 'flowbite-react'
import TextArea from '@/Components/TextArea'
import { formatIDR } from '@/utils'

export default function Form(props) {
    const { track } = props

    const [loading, setLoading] = useState(false)
    const [options, setOptions] = useState([])
    const [selectedOptionIndex, setSelectedOptionIndex] = useState('')
    const [timeslots, setTimeSlots] = useState([])
    const { data, setData, post, processing, errors } = useForm({
        attribute_json: null,
        fastboat_source_id: null,
        fastboat_destination_id: null,
        price: '',
        arrival_time: '00:00',
        departure_time: '00:00',
        is_publish: 1,
    })

    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === 'checkbox'
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        )
    }

    const handleSelectProduct = (item) => {
        setSelectedOptionIndex('')
        setOptions([])

        if (item === null) {
            setData('attribute_json', null)
            return
        }

        setLoading(true)
        setData('attribute_json', {
            id: item.id,
            name: item.name,
        })

        fetchOptions(item.id)
    }

    const handleSelectOption = (index) => {
        setSelectedOptionIndex(index)
        const option = options[index]

        setData('attribute_json', {
            ...data.attribute_json,
            ticket_type: {
                option_name: option.name,
                option_description: option.description,
                questions: option.questions,
                id: option.ticket_type_id,
                name: option.ticket_type_name,
                price: option.ticket_type_price,
            },
        })
    }

    const handleSelectTimeSlot = (time_slot) => {
        setData({
            ...data,
            arrival_time: time_slot,
            attribute_json: {
                ...data.attribute_json,
                ticket_type: {
                    ...data.attribute_json.ticket_type,
                    time_slot: time_slot,
                },
            },
        })
    }

    const handleSubmit = () => {
        if (isEmpty(track) === false) {
            post(route('fastboat.globaltix.update', track))
            return
        }
        post(route('fastboat.globaltix.store'))
    }

    const fetchOptions = (product_id, withSelected = false, typeId = null) => {
        axios
            .get(route('api.globaltix.option', { product_id }))
            .then((res) => {
                setOptions(res.data)
                if (withSelected) {
                    setSelectedOptionIndex(
                        res.data.findIndex((op) => op.ticket_type_id === typeId)
                    )
                }
            })
            .catch((err) => {
                if (err.response.data.message) {
                    alert(err.response.data.message)
                    return
                }
                alert(err)
            })
            .finally(() => {
                setLoading(false)
            })
    }

    useEffect(() => {
        if (isEmpty(track) === false) {
            const attributeJson = JSON.parse(track.attribute_json)
            setData({
                attribute_json: attributeJson,
                fastboat_source_id: track.fastboat_source_id,
                fastboat_destination_id: track.fastboat_destination_id,
                price: (+track.price).toFixed(0),
                arrival_time: track.arrival_time,
                departure_time: track.departure_time,
                is_publish: track.is_publish,
            })
            fetchOptions(attributeJson.id, true, attributeJson.ticket_type.id)
        }
    }, [track])

    useEffect(() => {
        if (selectedOptionIndex === '') {
            setTimeSlots([])
            return
        }
        setTimeSlots(options[selectedOptionIndex].time_slots)
    }, [selectedOptionIndex])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Globaltix Track'}
            action={'Form'}
            parent={route('fastboat.globaltix.index')}
        >
            <Head title={'Form'} />

            <div className="mx-auto sm:px-6 lg:px-8">
                <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col h-[1200px]">
                    <div className="text-xl font-bold mb-4">
                        {'Globaltix Track'}
                    </div>
                    <div className="mb-4">
                        <ProductSelectionInput
                            label="Globaltix Product"
                            itemSelected={data.attribute_json?.id}
                            onItemSelected={(item) => handleSelectProduct(item)}
                            error={errors['attribute_json']}
                        />
                    </div>
                    {loading ? (
                        <div className="w-full flex justify-center mt-8">
                            <Spinner size="lg" />
                        </div>
                    ) : (
                        <div>
                            <div>
                                <label
                                    htmlFor="first_name"
                                    className="block mb-2 text-sm font-medium text-gray-900"
                                >
                                    Option
                                </label>
                                <select
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    onChange={(e) =>
                                        handleSelectOption(e.target.value)
                                    }
                                    value={selectedOptionIndex}
                                >
                                    <option value=""></option>
                                    {options.map((option, index) => (
                                        <option value={index} key={index}>
                                            {option.name}
                                        </option>
                                    ))}
                                </select>
                                {errors['attribute_json.ticket_type'] && (
                                    <p className="mb-2 text-sm text-red-600 dark:text-red-500">
                                        {'The product option is required.'}
                                    </p>
                                )}
                            </div>
                            <div>
                                <label
                                    htmlFor="first_name"
                                    className="block my-2 text-sm font-medium text-gray-900"
                                >
                                    Time Slot
                                </label>
                                <select
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    onChange={(e) =>
                                        handleSelectTimeSlot(e.target.value)
                                    }
                                    value={
                                        data.attribute_json?.ticket_type
                                            ?.time_slot
                                    }
                                >
                                    <option value=""></option>
                                    {timeslots.map((timeslot, index) => (
                                        <option value={timeslot} key={index}>
                                            {timeslot}
                                        </option>
                                    ))}
                                </select>
                                {errors[
                                    'attribute_json.ticket_type.time_slot'
                                ] && (
                                    <p className="mb-2 text-sm text-red-600 dark:text-red-500">
                                        {'The option timeslot is required.'}
                                    </p>
                                )}
                            </div>
                            {data.attribute_json?.ticket_type && (
                                <>
                                    <div className="mt-2" />
                                    <TextArea
                                        value={`${
                                            data.attribute_json.ticket_type
                                                ?.option_name
                                        } \n\n${
                                            data.attribute_json.ticket_type
                                                ?.option_description
                                        } \n\n Harga: ${formatIDR(
                                            data.attribute_json.ticket_type
                                                ?.price
                                        )}`}
                                        readOnly={true}
                                        rows={14}
                                    />
                                </>
                            )}
                            <div className="mt-4" />
                            <PlaseSelectionInput
                                label="Source"
                                itemSelected={data.fastboat_source_id}
                                onItemSelected={(item) =>
                                    setData('fastboat_source_id', item.id)
                                }
                                error={errors.fastboat_source_id}
                            />
                            <PlaseSelectionInput
                                label="Destination"
                                itemSelected={data.fastboat_destination_id}
                                onItemSelected={(item) =>
                                    setData('fastboat_destination_id', item.id)
                                }
                                error={errors.fastboat_destination_id}
                            />
                            <div className="flex flex-row space-x-5 mb-4">
                                <FormInputTime
                                    label="Departure Time"
                                    value={data.arrival_time}
                                    onChange={(d) => setData('arrival_time', d)}
                                />
                                <FormInputTime
                                    label="Arrival Time"
                                    value={data.departure_time}
                                    onChange={(d) =>
                                        setData('departure_time', d)
                                    }
                                />
                            </div>
                            <FormInput
                                type="number"
                                name="price"
                                value={data.price}
                                onChange={handleOnChange}
                                label="Price"
                                error={errors.price}
                            />
                            <Checkbox
                                label="Publish"
                                value={+data.is_publish === 1}
                                name="is_publish"
                                onChange={handleOnChange}
                            />
                            <div className="mt-4">
                                <Button
                                    onClick={handleSubmit}
                                    processing={processing}
                                >
                                    Simpan
                                </Button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
