import React, { useEffect } from 'react'
import { isEmpty } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import { Head, Link, useForm } from '@inertiajs/react'
import FormInput from '@/Components/FormInput'
import { formatDate, formatIDR } from '@/utils'
import { payment_status } from '../constants'
import TextArea from '@/Components/TextArea'

export default function Form(props) {
    const { order } = props

    const { data, setData, put, processing, errors } = useForm({
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
        put(route('order.update', order))
    }

    useEffect(() => {
        if (isEmpty(order) === false) {
            setData({
                payment_status: order.payment_status,
                description: order.description,
            })
        }
    }, [order])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Order'}
            action={'#' + order.order_code}
            parent={route('order.index')}
        >
            <Head title={'Defail Order'} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="text-xl font-bold mb-4">{`Order #${order.order_code}`}</div>
                        <FormInput
                            name="order_code"
                            value={order.order_code}
                            label="Order Code"
                            readOnly={true}
                        />
                        <FormInput
                            name="order_date_formated"
                            value={order.order_date_formated}
                            label="Date"
                            readOnly={true}
                        />
                        <FormInput
                            name="customer.name"
                            value={`${order.customer.name} - ( ${order.customer.phone} )`}
                            label="Customer"
                            readOnly={true}
                        />
                        <FormInput
                            name="total"
                            value={formatIDR(order.total_amount)}
                            label="Total Order"
                            readOnly={true}
                        />
                        <FormInput
                            name="payment_channel"
                            value={order.payment_channel}
                            label="Payment Channel"
                            readOnly={true}
                        />
                        <FormInput
                            name="payment_status"
                            value={order.payment_status_text}
                            label="Payment Status"
                            readOnly={true}
                        />
                        <FormInput
                            name="payment_type"
                            value={order.payment_type}
                            label="Payment Type"
                            readOnly={true}
                        />
                        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 my-4">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="py-3 px-6">
                                        Detail
                                    </th>
                                    <th scope="col" className="py-3 px-6">
                                        Quantity
                                    </th>
                                    <th scope="col" className="py-3 px-6">
                                        Date
                                    </th>
                                    <th scope="col" className="py-3 px-6">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {order.items.map((item) => (
                                    <tr
                                        className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        key={item.id}
                                    >
                                        <td
                                            scope="row"
                                            className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            <div
                                                dangerouslySetInnerHTML={{
                                                    __html: `${item.detail}`,
                                                }}
                                            ></div>
                                        </td>
                                        <td className="py-4 px-6">
                                            {item.quantity}
                                        </td>
                                        <td className="py-4 px-6">
                                            {formatDate(item.date)}
                                        </td>
                                        <td className="py-4 px-6">
                                            {formatIDR(
                                                item.quantity * item.amount
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                        <FormInput
                            name="payment_Response"
                            value={order.payment_response}
                            label="Payment Response"
                            readOnly={true}
                        />
                        <div className="my-4">
                            <div className="mb-1 text-sm">Payment Status :</div>
                            <select
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                onChange={handleOnChange}
                                value={+data.payment_status}
                                name="payment_status"
                            >
                                {payment_status.map((p) => (
                                    <option key={p.value} value={p.value}>
                                        {p.text}
                                    </option>
                                ))}
                            </select>
                        </div>
                        <TextArea
                            name="description"
                            value={data.description}
                            onChange={handleOnChange}
                            label="Note"
                            error={errors.description}
                        />
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
