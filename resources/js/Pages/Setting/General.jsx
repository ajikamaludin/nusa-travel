import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import TextArea from '@/Components/TextArea';
import FormFile from '@/Components/FormFile';
import Checkbox from '@/Components/Checkbox';

const extractValue = (set, key) => {
    const find = set.find(s => s.key === key)
    if(find !== null) {
        if(find.type === 'image') {
            return find?.url
        }
        return find?.value
    }
    return ''
}

export default function General(props) {
    const {data, setData, post, reset, processing, errors} = useForm({
        site_name: extractValue(props.setting, 'G_SITE_NAME'),
        site_about: extractValue(props.setting, 'G_SITE_ABOUT'),
        site_welcome: extractValue(props.setting, 'G_SITE_WELCOME'),
        site_subwelcome: extractValue(props.setting, 'G_SITE_SUBWELCOME'),
        site_meta_desc: extractValue(props.setting, 'G_SITE_META_DESC'),
        site_meta_keyword: extractValue(props.setting, 'G_SITE_META_KEYWORD'),
        whatsapp_float_enable: extractValue(props.setting, 'G_WHATSAPP_FLOAT_ENABLE'),
        whatsapp_url: extractValue(props.setting, 'G_WHATSAPP_URL'),
        whatsapp_text: extractValue(props.setting, 'G_WHATSAPP_TEXT'),
        logo: null,
        site_logo: extractValue(props.setting, 'G_SITE_LOGO'),
        slide1: null,
        site_slide1: extractValue(props.setting, 'G_LANDING_SLIDE_1'),
        slide2: null,
        site_slide2: extractValue(props.setting, 'G_LANDING_SLIDE_2'),
        slide3: null,
        site_slide3: extractValue(props.setting, 'G_LANDING_SLIDE_3')
    })


    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        post(route('setting.update-general'), {
            onSuccess: () => {
                setTimeout(() => location.reload(), 3000)
            }
        })
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Setting"}
            action={"General"}
        >
            <Head title="General" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className='text-xl font-bold mb-4'>General</div>
                            <FormInput
                                name="site_name"
                                value={data.site_name}
                                onChange={handleOnChange}
                                label="Site Name"
                                error={errors.site_name}
                            />
                            <TextArea
                                name="site_about"
                                value={data.site_about}
                                onChange={handleOnChange}
                                label="Site About"
                                error={errors.site_about}
                            />

                            <FormFile
                                label={'Site Logo'}
                                onChange={e => setData('logo', e.target.files[0])}
                                error={errors.logo}
                                preview={
                                    <img src={`${data.site_logo}`} className="w-40 mb-1" alt="site logo"/>
                                }
                            />

                            <FormInput
                                name="site_welcome"
                                value={data.site_welcome}
                                onChange={handleOnChange}
                                label="Site Welcome"
                                error={errors.site_welcome}
                            />
                            <FormInput
                                name="site_subwelcome"
                                value={data.site_subwelcome}
                                onChange={handleOnChange}
                                label="Site Subwelcome"
                                error={errors.site_subwelcome}
                            />
                            <TextArea
                                name="site_meta_desc"
                                value={data.site_meta_desc}
                                onChange={handleOnChange}
                                label="Site Meta Description"
                                error={errors.site_meta_desc}
                            />
                            <TextArea
                                name="site_meta_keyword"
                                value={data.site_meta_keyword}
                                onChange={handleOnChange}
                                label="Site Meta Keyword"
                                error={errors.site_meta_keyword}
                            />

                            <FormFile
                                label={'Slide 1'}
                                onChange={e => setData('slide1', e.target.files[0])}
                                error={errors.slide1}
                                preview={
                                    <img src={`${data.site_slide1}`} className="w-full h-32 object-cover mb-1" alt="site logo"/>
                                }
                            />
                            <FormFile
                                label={'Slide 2'}
                                onChange={e => setData('slide2', e.target.files[0])}
                                error={errors.slide2}
                                preview={
                                    <img src={`${data.site_slide2}`} className="w-full h-32 object-cover mb-1" alt="site logo"/>
                                }
                            />
                            <FormFile
                                label={'Slide 3'}
                                onChange={e => setData('slide3', e.target.files[0])}
                                error={errors.slide3}
                                preview={
                                    <img src={`${data.site_slide3}`} className="w-full h-32 object-cover mb-1" alt="site logo"/>
                                }
                            />
                            <div className='border-2 rounded-lg p-2'>
                                <FormInput
                                    name="whatsapp_text"
                                    value={data.whatsapp_text}
                                    onChange={handleOnChange}
                                    label="Whatsapp Text"
                                    error={errors.whatsapp_text}
                                />
                                <FormInput
                                    name="whatsapp_url"
                                    value={data.whatsapp_url}
                                    onChange={handleOnChange}
                                    label="Whatsapp URL"
                                    placeholder="http://wa.me/6283840745543"
                                    error={errors.whatsapp_url}
                                />
                                <Checkbox
                                    name="whatsapp_float_enable"
                                    value={+data.whatsapp_float_enable === 1}
                                    onChange={handleOnChange}
                                    label="Show"
                                    error={errors.whatsapp_float_enable}
                                />
                            </div>
                        <div className='mt-4'>
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