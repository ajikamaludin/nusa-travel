import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard(props) {
    const { visitor_today, order_total, order_today, order_pending } = props
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Dashboard'}
            action={''}
        >
            <Head title="Dashboard" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className='px-2 w-full grid grid-cols-2 md:grid-cols-4 gap-2'>
                        <div className="p-4 overflow-hidden shadow sm:rounded-lg bg-white dark:bg-gray-800">
                            <div className="text-xl">Visitor</div>
                            <div className='text-2xl font-bold'>{visitor_today}</div>
                        </div>
                        <div className="p-4 overflow-hidden shadow sm:rounded-lg bg-white dark:bg-gray-800">
                            <div className="text-xl">Order</div>
                            <div className='text-2xl font-bold'>{order_total}</div>
                        </div>
                        <div className="p-4 overflow-hidden shadow sm:rounded-lg bg-white dark:bg-gray-800">
                            <div className="text-xl">Order Today</div>
                            <div className='text-2xl font-bold'>{order_today}</div>
                        </div>
                        <div className="p-4 overflow-hidden shadow sm:rounded-lg bg-white dark:bg-gray-800">
                            <div className="text-xl">Order Pending</div>
                            <div className='text-2xl font-bold'>{order_pending}</div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
