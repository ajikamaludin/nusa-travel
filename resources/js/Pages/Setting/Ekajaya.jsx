import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';

export default function Payment(props) {
    const { setting } = props
    
    const {data, setData, post, processing, errors} = useForm({
        ekajaya_apikey: setting[0].EKAJAYA_APIKEY,
        ekajaya_host: setting[1].EKAJAYA_HOST,
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        post(route('setting.update-ekajaya'))
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Setting"}
            action={"Ekajaya API Integration"}
            parent={route(route().current())}
        >
            <Head title="Ekajaya API Integration" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className='text-xl font-bold mb-4'>Ekajaya API Integration</div>
                        <FormInput
                            name="ekajaya_host"
                            value={data.ekajaya_host}
                            onChange={handleOnChange}
                            label="API Host"
                            error={errors.ekajaya_host}
                        />
                        <FormInput
                            name="ekajaya_apikey"
                            value={data.ekajaya_apikey}
                            onChange={handleOnChange}
                            label="API Key"
                            error={errors.ekajaya_apikey}
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