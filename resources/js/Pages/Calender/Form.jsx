import React, { useEffect } from 'react'
import { Head, useForm } from '@inertiajs/react'
import { isEmpty } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import FormInputDate from '@/Components/FormInputDate'
import SelectionInputTrack from './SelectionInput'

export default function Form(props) {
    const { date } = props
    const {
        data,
        setData,
        post,
        put,
        delete: destroy,
        processing,
        errors,
    } = useForm({
        close_date: '',
        fastboat_track_id: '',
    })

    const handleSubmit = () => {
        if (isEmpty(date) === false) {
            put(route('calender.update', date.id))
            return
        }
        post(route('calender.store'))
    }

    const handleDelete = () => {
        if (isEmpty(date) === false) {
            destroy(route('calender.destroy', date.id))
            return
        }
    }

    useEffect(() => {
        if (isEmpty(date) === false) {
            setData({
                close_date: date.close_date,
                fastboat_track_id: date.fastboat_track_id,
            })
        }
    }, [date])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Close Date'}
            action={'Form'}
            parent={route('calender.index')}
        >
            <Head title="Close Date" />
            <div className="mx-auto sm:px-6 lg:px-8">
                <div className="p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                    <div className="text-xl font-bold mb-4">Close Date</div>
                    <FormInputDate
                        selected={data.close_date}
                        onChange={(date) => setData('close_date', date)}
                        label="Date"
                        error={errors.close_date}
                    />
                    <SelectionInputTrack
                        label="Fastboat Track"
                        itemSelected={data.fastboat_track_id}
                        onItemSelected={(item) =>
                            setData('fastboat_track_id', item.id)
                        }
                        error={errors.fastboat_track_id}
                    />
                    <div className="mt-8 flex flex-row justify-between">
                        <Button onClick={handleSubmit} processing={processing}>
                            Save
                        </Button>
                        <Button
                            onClick={handleDelete}
                            processing={processing}
                            type="secondary"
                        >
                            Delete
                        </Button>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
