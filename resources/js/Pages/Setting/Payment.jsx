import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';

export default function Payment(props) {
    const { setting, notification_url } = props
    
    const {data, setData, post, processing, errors} = useForm({
        midtrans_client_key: setting[0].midtrans_client_key,
        midtrans_merchant_id: setting[1].midtrans_merchant_id,
        midtrans_server_key: setting[2].midtrans_server_key,
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        post(route('setting.update-payment'))
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Setting"}
            action={"Payment"}
        >
            <Head title="Payment" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className='text-xl font-bold mb-4'>Midtrans Payment</div>
                        <FormInput
                            name="midtrans_server_key"
                            value={data.midtrans_server_key}
                            onChange={handleOnChange}
                            label="Midtrans Server Key"
                            error={errors.midtrans_server_key}
                        />
                        <FormInput
                            name="midtrans_client_key"
                            value={data.midtrans_client_key}
                            onChange={handleOnChange}
                            label="Midtrans Client Key"
                            error={errors.midtrans_client_key}
                        />
                        <FormInput
                            name="midtrans_merchant_id"
                            value={data.midtrans_merchant_id}
                            onChange={handleOnChange}
                            label="Midtrans Merchant ID"
                            error={errors.midtrans_merchant_id}
                        />
                        <FormInput
                            value={notification_url}
                            label="Notification URL"
                            readOnly={true}
                        />
                        <div className='mt-2'>
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