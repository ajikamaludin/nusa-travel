import React, { useEffect, Suspense, useState } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormInput from '@/Components/FormInput';
import Checkbox from '@/Components/Checkbox';
import ProductSelectionInput from './SelectionInput';
import PlaseSelectionInput from '../FastboatPlace/SelectionInput';
import FormInputTime from '@/Components/FormInputTime';
import axios from 'axios';
import { Spinner } from 'flowbite-react';
import TextArea from '@/Components/TextArea';
import { formatIDR } from '@/utils';

export default function Form(props) {
    const { track } = props

    const [loading, setLoading] = useState(false)
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
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSelectProduct = (item) => {
        if (item === null) {
            setData('attribute_json', null)
            return
        }
        setLoading(true)
        axios.get(route('api.globaltix.option', { product_id: item.id }))
        .then(res => {
            const data = res.data
            setData('attribute_json', {
                id: item.id,
                name: item.name,
                ticket_type: {
                    option_name: data.name,
                    option_description: data.description,
                    questions: data.questions,
                    id: data.ticket_type_id,
                    name: data.ticket_type_name,
                    price: data.ticket_type_price,
                    time_slot: data.time_slot
                }
            })
        })
        .catch(err => {
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

    const handleSubmit = () => {
        if (isEmpty(track) === false) {
            post(route('fastboat.globaltix.update', track))
            return
        }
        post(route('fastboat.globaltix.store'))
    }

    useEffect(() => {
        if (isEmpty(track) === false) {
            setData({
                attribute_json: JSON.parse(track.attribute_json),
                fastboat_source_id: track.fastboat_source_id,
                fastboat_destination_id: track.fastboat_destination_id,
                price: (+track.price).toFixed(0),
                arrival_time: track.arrival_time,
                departure_time: track.departure_time,
                is_publish: track.is_publish,
            })
        }
    }, [track])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Globaltix Track"}
            action={"Form"}
            parent={route('fastboat.globaltix.index')}
        >
            <Head title={"Form"} />

            <div className="mx-auto sm:px-6 lg:px-8">
                <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col min-h-screen">
                    <div className='text-xl font-bold mb-4'>{"Globaltix Track"}</div>
                    <div className='mb-4'>
                        <ProductSelectionInput
                            label="Globaltix Product"
                            itemSelected={data.attribute_json?.id}
                            onItemSelected={(item) => handleSelectProduct(item)}
                            error={errors.product}
                        />
                    </div>
                    {loading ? (
                        <div className='w-full flex justify-center mt-8'>
                            <Spinner size="lg"/>
                        </div>
                    ) : (
                        <div>
                            {data.attribute_json !== null && (
                                <TextArea
                                    value={`${data.attribute_json.ticket_type.option_name} \n\n${data.attribute_json.ticket_type.option_description} \n\n Harga: ${formatIDR(data.attribute_json.ticket_type.price)}`}
                                    readOnly={true}
                                    rows={14}
                                />
                            )}
                            <PlaseSelectionInput
                                label="Source"
                                itemSelected={data.fastboat_source_id}
                                onItemSelected={(item) => setData('fastboat_source_id', item.id)}
                                error={errors.fastboat_source_id}
                            />
                            <PlaseSelectionInput
                                label="Destination"
                                itemSelected={data.fastboat_destination_id}
                                onItemSelected={(item) => setData('fastboat_destination_id', item.id)}
                                error={errors.fastboat_destination_id}
                            />
                            <div className='flex flex-row space-x-5 mb-4'>
                                <FormInputTime
                                    label="Departure Time"
                                    value={data.arrival_time}
                                    onChange={d => setData("arrival_time", d)}
                                />
                                <FormInputTime
                                    label="Arrival Time"
                                    value={data.departure_time}
                                    onChange={d => setData("departure_time", d)}
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
                            <div className='mt-4'>
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
    );
}