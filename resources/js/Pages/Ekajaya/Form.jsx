import React, { useEffect } from 'react'
import { isEmpty } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import { Head, useForm } from '@inertiajs/react'
import FormInput from '@/Components/FormInput'
import ProductSelectionInput from './SelectionInput'

export default function Form(props) {
    const { track } = props

    const { data, setData, post, processing, errors } = useForm({
        fastboat_track_id: null,
        price: 0,
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

    const handleSubmit = () => {
        if (isEmpty(track) === false) {
            post(route('fastboat.ekajaya.update', track))
            return
        }
        post(route('fastboat.ekajaya.store'))
    }

    useEffect(() => {
        if (isEmpty(track) === false) {
            setData({
                fastboat_track_id: track.id,
                price: (+track.price).toFixed(0),
            })
        }
    }, [track])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Api Track'}
            action={'Form'}
            parent={route('fastboat.ekajaya.index')}
        >
            <Head title={'Form'} />

            <div className="mx-auto sm:px-6 lg:px-8">
                <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col h-[1200px]">
                    <div className="text-xl font-bold mb-4">{'Api Track'}</div>
                    <div className="mb-4">
                        <ProductSelectionInput
                            label="Api Tracks"
                            itemSelected={data.fastboat_track_id}
                            onItemSelected={(item) =>
                                setData('fastboat_track_id', item.id)
                            }
                            error={errors.fastboat_track_id}
                        />
                    </div>
                    <div>
                        <FormInput
                            type="number"
                            name="price"
                            value={data.price}
                            onChange={handleOnChange}
                            label="Price"
                            error={errors.price}
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
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
