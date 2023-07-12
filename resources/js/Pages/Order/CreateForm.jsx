import React, { useState } from 'react'
import { Head, Link, useForm } from '@inertiajs/react'
import { HiX } from 'react-icons/hi'

import { payment_status } from '../constants'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Button from '@/Components/Button'
import CustomerSelectionInput from '../Customer/SelectionInput'
import TourPackage from './Modal/TourPackage'
import { useModalState } from '@/hooks'
import CarRental from './Modal/CarRental'
import Track from './Modal/Track'
import { dateToString, formatIDR } from '@/utils'
import FormInput from '@/Components/FormInput'
import FormInputDate from '@/Components/FormInputDate'
import moment from 'moment'
import { Alert } from 'flowbite-react'

export default function CreateForm(props) {
    const { _date } = props
    const tourPackageModal = useModalState()
    const carRentalModal = useModalState()
    const trackModal = useModalState()

    const { data, setData, post, processing, errors } = useForm({
        items: [],
        customer_id: null,
        date: dateToString(_date),
        payment_status: '',
    })

    const handleAddItem = (item, type) => {
        const isExists = data.items.find(
            (i) => i.id === item.id && i.type === type
        )

        if (isExists) {
            return
        }

        let newItem
        if (type === 'track') {
            newItem = {
                id: item.id,
                name: item.alternative_name,
                price: item.price,
            }
        } else {
            newItem = {
                id: item.id,
                name: item.name,
                price: item.price,
            }
        }

        setData(
            'items',
            data.items.concat({
                ...newItem,
                qty: 1,
                type,
            })
        )
    }

    const handleRemoveItem = (index) => {
        setData(
            'items',
            data.items.filter((_, i) => i !== index)
        )
    }

    const handleChangeValueItem = (e, index) => {
        setData(
            'items',
            data.items.map((item, i) => {
                if (i === index) {
                    item[e.target.name] = e.target.value
                    return item
                }
                return item
            })
        )
    }

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
        post(route('order.store'))
    }

    const total = data.items.reduce((p, c, _) => p + +c.price * +c.qty, 0)

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

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="text-xl font-bold mb-4">{`Create Order`}</div>
                        {/*  */}
                        <div className="px-1">
                            <CustomerSelectionInput
                                placeholder="Pilih Customer"
                                itemSelected={data.customer_id}
                                onItemSelected={(id) =>
                                    setData('customer_id', id)
                                }
                                agent={null}
                                active={null}
                                error={errors.customer_id}
                            />
                        </div>
                        <div className="px-1 pt-2">
                            <FormInputDate
                                placeholder="Tanggal"
                                selected={data.date}
                                onChange={(date) => {
                                    setData('date', date)
                                }}
                                error={errors.date}
                            />
                        </div>
                        <div className="overflow-auto mt-5 px-1">
                            <div className="w-full">Pilih Item : </div>
                            <div className="w-full flex flex-row gap-2 mb-4">
                                <div
                                    className="border-gray-600 border bg-gray-600 text-white hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                    onClick={() => tourPackageModal.toggle()}
                                >
                                    tour package
                                </div>
                                <div
                                    className="border-gray-600 border bg-gray-600 text-white hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                    onClick={() => carRentalModal.toggle()}
                                >
                                    car rental
                                </div>
                                <div
                                    className="border-gray-600 border bg-gray-600 text-white hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                    onClick={() => trackModal.toggle()}
                                >
                                    track
                                </div>
                            </div>
                            <div className="w-full">
                                {errors.items && (
                                    <Alert color="failure">
                                        Item harus dimasukan
                                    </Alert>
                                )}
                            </div>
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Item
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6 w-24 text-right"
                                            >
                                                Quantity
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6 text-right"
                                            >
                                                Subtotal
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6 w-10"
                                            />
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.items.map((item, index) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={index}
                                            >
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {item.name}
                                                </td>
                                                <td className="py-4 px-6 text-right">
                                                    <FormInput
                                                        value={item.qty}
                                                        onChange={(e) =>
                                                            handleChangeValueItem(
                                                                e,
                                                                index
                                                            )
                                                        }
                                                        placeholder={`qty`}
                                                        name="qty"
                                                        className="text-right"
                                                    />
                                                </td>
                                                <td className="py-4 px-6 text-right">
                                                    {formatIDR(
                                                        item.price * item.qty
                                                    )}
                                                </td>
                                                <td className="py-4 px-6 flex flex-row justify-end items-center">
                                                    <HiX
                                                        className="text-red-600 w-5 h-5"
                                                        onClick={() =>
                                                            handleRemoveItem(
                                                                index
                                                            )
                                                        }
                                                    />
                                                </td>
                                            </tr>
                                        ))}
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                scope="row"
                                                className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            ></td>
                                            <td className="py-4 px-6 text-right font-bold">
                                                TOTAL
                                            </td>
                                            <td className="py-4 px-6 text-right font-bold">
                                                {formatIDR(total)}
                                            </td>
                                            <td className="py-4 px-6 flex justify-end"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div className="w-full flex flex-row justify-end">
                            <div className="w-1/2">
                                <div className="mb-1 text-sm">
                                    Payment Status :
                                </div>
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
                        </div>
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
                                    className="border-gray-600 border hover:bg-gray-600 hover:text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                >
                                    Kembali
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <TourPackage
                modalState={tourPackageModal}
                onItemClick={(item) => handleAddItem(item, 'tour')}
            />
            <CarRental
                modalState={carRentalModal}
                onItemClick={(item) => handleAddItem(item, 'car')}
            />
            <Track
                modalState={trackModal}
                onItemClick={(item) => handleAddItem(item, 'track')}
            />
        </AuthenticatedLayout>
    )
}
