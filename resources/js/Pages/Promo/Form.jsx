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

    const { data, setData, post, processing, errors } = useForm({
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
        condition_type: '',
        amount_buys: '',
        amount_tiket: '',
        ranges_day: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        if (isEmpty(promo) === false) {
            post(route('promo.update', promo))
            return
        }
        post(route('promo.store'))
    }

    const renderComponetType=()=>{
        let terms=data.condition_type
        switch(terms){
            case "1":
                return  <FormInput
                name="amount_buys"
                value={data.amount_buys}
                onChange={handleOnChange}
                label="Jumlah Pembelian Tiket"
                error={errors.amount_buys}
            />
           
            case "2":
                return  <FormInput
                name="ranges_day"
                value={data.ranges_day == null ? '' : data.ranges_day}
                onChange={handleOnChange}
                label="Jumlah Hari Sebelum Pesan"
                error={errors.ranges_day}
            />
            case "3":
                return  <FormInput
                name="ranges_day"
                value={data.ranges_day == null ? '' : data.ranges_day}
                onChange={handleOnChange}
                label="Jumlah Haris Sesudah Pesan"
                error={errors.ranges_day}
            />
            case "4":
                return  <><FormInput
                name="amount_buys"
                value={data.amount_buys == null ? '' : data.amount_buys}
                onChange={handleOnChange}
                label="Jumlah Pembelian Tiket"
                error={errors.amount_buys}
            />
            <FormInput
                name="amount_tiket"
                value={data.amount_tiket == null ? '' : data.amount_tiket}
                onChange={handleOnChange}
                label="Jumlah Tiket Gratis"
                error={errors.amount_tiket}
            />
            </>
            
                
        }
    }

    useEffect(() => {
        if (isEmpty(promo) === false) {
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
                condition_type: promo.condition_type,
                amount_buys: promo.amount_buys,
                amount_tiket: promo.amount_tiket,
                ranges_day: promo.ranges_day,
            })
        }
    }, [promo])

    
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
                            <label className="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Syarat & Ketentuan</label>
                            <select className="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={data.condition_type} name="condition_type">
                            <option  value={0}>{"Basic"}</option>
                                {['Graded', 'Early Bird','Last Minute','Get Pack Get Ticket'].map((p, index) => (
                                    <option key={p} value={index+1}>{p}</option>
                                ))}
                            </select>
                                    {renderComponetType()}
                        </div>
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