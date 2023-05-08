import React from 'react'
import { Head, useForm, router } from '@inertiajs/react'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import FormInput from '@/Components/FormInput'
import Button from '@/Components/Button'
import Checkbox from '@/Components/Checkbox'
import FormFile from '@/Components/FormFile'

export default function Payment(props) {
    const { setting } = props

    const { data, setData, post, processing, errors } = useForm({
        globaltix_enable: setting[0].GLOBALTIX_ENABLE,
        globaltix_host: setting[1].GLOBALTIX_HOST,
        globaltix_logo: setting[2].GLOBALTIX_LOGO,
        globaltix_password: setting[3].GLOBALTIX_PASSWORD,
        globaltix_username: setting[4].GLOBALTIX_USERNAME,
        logo: null,
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
        post(route('setting.update-globaltix'), {
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
            action={'Globaltix API Integration'}
            parent={route(route().current())}
        >
            <Head title="Globaltix API Integration" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className="text-xl font-bold mb-4">
                            Globaltix API Integration
                        </div>
                        <FormFile
                            label={'Logo'}
                            onChange={(e) => setData('logo', e.target.files[0])}
                            error={errors.logo}
                            preview={
                                <img
                                    src={`${data.globaltix_logo}`}
                                    className="w-40 mb-1"
                                    alt="site logo"
                                />
                            }
                        />
                        <FormInput
                            name="globaltix_host"
                            value={data.globaltix_host}
                            onChange={handleOnChange}
                            label="API Host"
                            error={errors.globaltix_host}
                        />
                        <FormInput
                            name="globaltix_username"
                            value={data.globaltix_username}
                            onChange={handleOnChange}
                            label="API Username"
                            error={errors.globaltix_username}
                        />
                        <FormInput
                            name="globaltix_password"
                            value={data.globaltix_password}
                            onChange={handleOnChange}
                            label="API Password"
                            error={errors.globaltix_password}
                        />
                        <Checkbox
                            label="Enable"
                            value={+data.globaltix_enable === 1}
                            name="globaltix_enable"
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
