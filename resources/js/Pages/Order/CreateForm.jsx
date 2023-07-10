import React, { useEffect } from 'react'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import { Head, Link, useForm } from '@inertiajs/react'

export default function CreateForm(props) {
    const { data, setData, post, processing, errors } = useForm({
        payment_status: '',
        description: '',
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
        post(route('order.store', order))
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Order'}
            action={'Create Order'}
            parent={route('order.index')}
        >
            <Head title={'Create Order'} />

            {/* create ordernya adalah  */}
            {/* list item order */}
            {/*  */}
            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="text-xl font-bold mb-4">{`Create Order`}</div>
                        {/*  */}
                        <div className="my-8 flex flex-row justify-between items-center">
                            <Button
                                onClick={handleSubmit}
                                processing={processing}
                            >
                                Simpan
                            </Button>
                            <div>
                                <Link
                                    href={route('order.index')}
                                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                >
                                    Kembali
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
