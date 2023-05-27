import React from 'react'
import { Head, router, useForm } from '@inertiajs/react'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import FormInput from '@/Components/FormInput'
import FormFile from '@/Components/FormFile'
import Button from '@/Components/Button'
import Checkbox from '@/Components/Checkbox'
import { extractValue } from './utils'
import { HiClipboard } from 'react-icons/hi'

export default function Payment(props) {
    const { setting, midtrans_notification_url, doku_notification_url } = props

    const { data, setData, post, processing, errors } = useForm({
        midtrans_client_key: extractValue(setting, 'midtrans_client_key'),
        midtrans_merchant_id: extractValue(setting, 'midtrans_merchant_id'),
        midtrans_server_key: extractValue(setting, 'midtrans_server_key'),
        midtrans_enable: extractValue(setting, 'midtrans_enable'),
        midtrans_logo: extractValue(setting, 'midtrans_logo'),
        midtrans_logo_file: null,
        DOKU_SECRET_KEY: extractValue(setting, 'DOKU_SECRET_KEY'),
        DOKU_CLIENT_ID: extractValue(setting, 'DOKU_CLIENT_ID'),
        DOKU_ENABLE: extractValue(setting, 'DOKU_ENABLE'),
        DOKU_LOGO: extractValue(setting, 'DOKU_LOGO'),
        DOKU_LOGO_FILE: null,
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
        post(route('setting.update-payment'), {
            onSuccess: () => {
                setTimeout(() => router.get(route(route().current())), 3000)
            },
        })
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Setting'}
            action={'Payment'}
            parent={route(route().current())}
        >
            <Head title="Payment" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className="border border-gray-200 rounded-lg p-5">
                            <div className="text-xl font-bold mb-4">
                                Midtrans Payment
                            </div>
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
                            <FormFile
                                label={'Payment Logo'}
                                onChange={(e) =>
                                    setData(
                                        'midtrans_logo_file',
                                        e.target.files[0]
                                    )
                                }
                                error={errors.midtrans_logo_file}
                                preview={
                                    <img
                                        src={`${data.midtrans_logo}`}
                                        className="w-40 mb-1"
                                        alt="site logo"
                                    />
                                }
                            />
                            <FormInput
                                value={midtrans_notification_url}
                                label="Notification URL"
                                readOnly={true}
                            />
                            <Checkbox
                                label="Enable"
                                value={+data.midtrans_enable === 1}
                                onChange={handleOnChange}
                                name="midtrans_enable"
                            />
                        </div>
                        <div className="border border-gray-200 rounded-lg p-5 mt-2">
                            <div className="text-xl font-bold mb-4">
                                DOKU Payment
                            </div>
                            <FormInput
                                name="DOKU_SECRET_KEY"
                                value={data.DOKU_SECRET_KEY}
                                onChange={handleOnChange}
                                label="DOKU Secret Key"
                                error={errors.DOKU_SECRET_KEY}
                            />
                            <FormInput
                                name="DOKU_CLIENT_ID"
                                value={data.DOKU_CLIENT_ID}
                                onChange={handleOnChange}
                                label="DOKU Client ID"
                                error={errors.DOKU_CLIENT_ID}
                            />
                            <FormFile
                                label={'Payment Logo'}
                                onChange={(e) =>
                                    setData('DOKU_LOGO_FILE', e.target.files[0])
                                }
                                error={errors.DOKU_LOGO_FILE}
                                preview={
                                    <img
                                        src={`${data.DOKU_LOGO}`}
                                        className="w-40 mb-1"
                                        alt="site logo"
                                    />
                                }
                            />
                            <FormInput
                                value={doku_notification_url}
                                label="Notification URL"
                                readOnly={true}
                            />
                            <Checkbox
                                label="Enable"
                                value={+data.DOKU_ENABLE === 1}
                                onChange={handleOnChange}
                                name="DOKU_ENABLE"
                            />
                        </div>

                        <div className="mt-2"></div>

                        <div className="mt-2">
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
    )
}
