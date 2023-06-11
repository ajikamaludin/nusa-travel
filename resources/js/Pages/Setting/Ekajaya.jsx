import React from 'react'
import { Head, useForm, router } from '@inertiajs/react'

import { extractValue } from './utils'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import FormInput from '@/Components/FormInput'
import FormFile from '@/Components/FormFile'
import Button from '@/Components/Button'
import Checkbox from '@/Components/Checkbox'

export default function Payment(props) {
    const { setting } = props

    const { data, setData, post, processing, errors } = useForm({
        ekajaya_apikey: extractValue(setting, 'EKAJAYA_APIKEY'),
        ekajaya_enable: extractValue(setting, 'EKAJAYA_ENABLE'),
        ekajaya_host: extractValue(setting, 'EKAJAYA_HOST'),
        ekajaya_logo: null,
        ekajaya_logo_url: extractValue(setting, 'EKAJAYA_LOGO'),
        ekajaya_mark: extractValue(setting, 'EKAJAYA_MARK'),
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
        post(route('setting.update-ekajaya'), {
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
            action={'API Integration'}
            parent={route(route().current())}
        >
            <Head title="API Integration" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className="text-xl font-bold mb-4">
                            API Integration
                        </div>
                        <FormFile
                            label={'Logo'}
                            onChange={(e) =>
                                setData('ekajaya_logo', e.target.files[0])
                            }
                            error={errors.ekajaya_logo}
                            preview={
                                <img
                                    src={`${data.ekajaya_logo_url}`}
                                    className="w-40 mb-1"
                                    alt="ekajaya logo"
                                />
                            }
                        />
                        <FormInput
                            name="ekajaya_mark"
                            value={data.ekajaya_mark}
                            onChange={handleOnChange}
                            label="API Mark"
                            error={errors.ekajaya_mark}
                        />
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
                        <Checkbox
                            label="Enable"
                            value={+data.ekajaya_enable === 1}
                            name="ekajaya_enable"
                            onChange={handleOnChange}
                        />
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
