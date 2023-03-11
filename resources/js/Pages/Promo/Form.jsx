import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormInput from '@/Components/FormInput';
import Checkbox from '@/Components/Checkbox';
import FormInputDate from '@/Components/FormInputDate';

export default function Form(props) {
    const { promo } = props

    const {data, setData, post, processing, errors} = useForm({
        code: '',
        name: '',
        is_active: 1,
        cover_image: '',
        discount_type: 0,
        discount_amount: '',
        available_start_date: '',
        available_end_date: '',
        order_start_date: '',
        order_end_date: '',
        user_perday_limit: '',
        order_perday_limit: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        if(isEmpty(promo) === false) {
            post(route('promo.update', promo))
            return
        }
        post(route('promo.store'))
    }

    useEffect(() => {
        if(isEmpty(promo) === false) {
            setData({
                code: promo.code,
                name: promo.name,
                is_active: +promo.is_active,
                cover_image: promo.cover_image,
                discount_type: +promo.discount_type,
                discount_amount: promo.discount_amount,
                available_start_date: promo.available_start_date,
                available_end_date: promo.available_end_date,
                order_start_date: promo.order_start_date,
                order_end_date: promo.order_end_date,
                user_perday_limit: promo.user_perday_limit,
                order_perday_limit: promo.order_perday_limit,
            })
        }
    }, [promo]) 

    console.log(data)
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Fastboat"}
            action={"Promo"}
        >
            <Head title={"Form"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{"Promo"}</div>
                        <FormInput
                            name="code"
                            value={data.code}
                            onChange={handleOnChange}
                            label="Code"
                            error={errors.code}
                        />
                        <FormInput
                            name="name"
                            value={data.name}
                            onChange={handleOnChange}
                            label="Name"
                            error={errors.name}
                        />
                        <div className='border-2 p-2 my-2 rounded'>
                            <label className="block mb-2 text-sm font-bold text-gray-900">Ketersediaan</label>
                            <FormInputDate
                                selected={data.available_start_date}
                                onChange={date => setData("available_start_date", date)}
                                label="Tanggal Mulai"
                                error={errors.available_start_date}
                            />
                            <FormInputDate
                                selected={data.available_end_date}
                                onChange={date => setData("available_end_date", date)}
                                label="Tanggal Terakhir"
                                error={errors.available_end_date}
                            />
                        </div>
                        <div className='border-2 p-2 my-2 rounded'>
                            <label className="block mb-2 text-sm font-bold text-gray-900">Order Pada</label>
                            <FormInputDate
                                selected={data.order_start_date}
                                onChange={date => setData("order_start_date", date)}
                                label="Tanggal Mulai"
                                error={errors.order_start_date}
                            />
                            <FormInputDate
                                selected={data.order_end_date}
                                onChange={date => setData("order_end_date", date)}
                                label="Tanggal Terakhir"
                                error={errors.order_end_date}
                            />
                        </div>
                        <div className='border-2 p-2 my-2 rounded'>
                            <label className="block mb-2 text-sm font-bold text-gray-900">Limit</label>
                            <FormInput
                                type="number"
                                name="user_perday_limit"
                                value={data.user_perday_limit}
                                onChange={handleOnChange}
                                label="User Limit Usage"
                                error={errors.user_perday_limit}
                            />
                            <FormInput
                                type="number"
                                name="order_perday_limit"
                                value={data.order_perday_limit}
                                onChange={handleOnChange}
                                label="Order Limit PerDay"
                                error={errors.order_perday_limit}
                            />
                        </div>
                        <div className='border-2 p-2 my-2 rounded'>
                            <label className="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Discount</label>
                            <FormInput
                                type="number"
                                name="discount_amount"
                                value={data.discount_amount}
                                onChange={handleOnChange}
                                placeholder={+data.discount_type === 1 ? 'Percent' : 'Amount'}
                                error={errors.discount_amount}
                            />
                            <Checkbox
                                name="discount_type"
                                value={+data.discount_type === 1}
                                onChange={handleOnChange}
                                label={+data.discount_type === 1 ? 'Percent' : 'Amount'}
                            />
                        </div>
                        <div className='mt-4'>
                            <Checkbox
                                name="is_active"
                                value={+data.is_active === 1}
                                onChange={handleOnChange}
                                label="Active"
                            />
                        </div>

                        <div className='mt-8'>
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
    );
}