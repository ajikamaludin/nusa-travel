import React, { useEffect } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, Link, useForm } from '@inertiajs/react';
import FormInput from '@/Components/FormInput';
import { formatDate, formatIDR } from '@/utils';

export default function Form(props) {
    const { order } = props

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Order"}
            action={'#' + order.order_code}
            parent={route('order.index')}
        >
            <Head title={"Defail Order"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{`Order #${order.order_code}`}</div>
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
                            value={`${order.customer.name} - ( ${order.customer.phone} )` }
                            label="Customer"
                            readOnly={true}
                        />
                        <FormInput
                            name="total"
                            value={formatIDR(+order.total_amount + +order.total_discount)}
                            label="Total Order"
                            readOnly={true}
                        />
                        <FormInput
                            name="total"
                            value={formatIDR(order.total_discount)}
                            label="Total Discount"
                            readOnly={true}
                        />
                        <FormInput
                            name="total"
                            value={formatIDR(order.total_amount)}
                            label="Total Payed"
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
                        
                        <div className='mt-2'>
                            <label className="block mb-2 text-sm font-medium text-gray-900">Item Order</label>
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
                                    {order.items.map(item => (
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={item.id}>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div dangerouslySetInnerHTML={{ __html: `${item.detail}` }}></div>
                                            </td>
                                            <td className="py-4 px-6">
                                                {item.quantity}
                                            </td>
                                            <td className="py-4 px-6">
                                                {formatDate(item.date)}
                                            </td>
                                            <td className="py-4 px-6">
                                                {formatIDR(item.quantity * item.amount)}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        {order.items[0]?.passengers?.length > 0 && (
                            <div className='mt-2'>
                                <label className="block mb-2 text-sm font-medium text-gray-900">Passengers</label>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 my-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="py-3 px-6">
                                                Name
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                National 
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Nation ID 
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Type
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {order.items[0].passengers.map(passenger => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={passenger.id}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {passenger.name}
                                                </td>
                                                <td className="py-4 px-6">
                                                    {passenger.nation}
                                                </td>
                                                <td className="py-4 px-6">
                                                    {passenger.national_id}
                                                </td>
                                                <td className="py-4 px-6">
                                                    {+passenger.type === 1 ? 'Infant' : 'Adult'}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                        <div className='mt-2'>
                            <label className="block mb-2 text-sm font-medium text-gray-900">Promo Applied</label>
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 my-4">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="py-3 px-6">
                                            Code
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Discount Amount 
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Desc 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {order.promos.map(promo => (
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={promo.id}>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {promo.promo_code}
                                            </td>
                                            <td className="py-4 px-6">
                                                {formatIDR(promo.promo_amount)}
                                            </td>
                                            <td className="py-4 px-6">
                                                {promo.promo && (
                                                    <Link href={route('promo.edit', promo.promo)} className="text-blue-500">
                                                    {promo?.promo?.name}
                                                    </Link>
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <FormInput
                            name="payment_Response"
                            value={(order.payment_response)}
                            label="Payment Response"
                            readOnly={true}
                        />
                        <div className='my-8'>
                            <Link
                                href={route('order.index')}
                                className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5'
                            >
                                Kembali
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}