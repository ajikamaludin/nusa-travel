import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormInput from '@/Components/FormInput';
import FormFile from '@/Components/FormFile';

const TinyEditor  = React.lazy(() => import('@/Components/TinyMCE'));

export default function Form(props) {
    const { fastboat } = props

    const {data, setData, post, processing, errors} = useForm({
        number: '',
        name: '',
        description: '',
        capacity: '',
        cover_image: '',
        cover_url: ''
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        if(isEmpty(fastboat) === false) {
            post(route('fastboat.fastboat.update', fastboat))
            return
        }
        post(route('fastboat.fastboat.store'))
    }

    useEffect(() => {
        if(isEmpty(fastboat) === false) {
            setData({
                number: fastboat.number,
                name: fastboat.name,
                description: fastboat.description,
                capacity: fastboat.capacity,
                cover_url: fastboat.cover_url
            })
        }
    }, [fastboat]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Fastboat"}
            action={""}
            parent={route('fastboat.fastboat.index')}
        >
            <Head title={"Fastboat"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{"Fastboat"}</div>
                        <FormInput
                            name="number"
                            value={data.number}
                            onChange={handleOnChange}
                            label="Number"
                            error={errors.number}
                        />
                        <FormInput
                            name="name"
                            value={data.name}
                            onChange={handleOnChange}
                            label="Name"
                            error={errors.name}
                        />
                        <FormInput
                            type="number"
                            name="capacity"
                            value={data.capacity}
                            onChange={handleOnChange}
                            label="Capacity"
                            error={errors.capacity}
                        />
                        <div className='py-4'>
                            <Suspense fallback={<div>Loading...</div>}>
                                <label>Description</label>
                                <TinyEditor
                                    value={data.description}
                                    init={{
                                        height: 800,
                                        // menubar: false,
                                        menubar: 'file edit view insert format tools table help',
                                        plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
                                        toolbar_mode: 'scrolling',
                                        toolbar: 'undo redo | insertfile image media link | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | charmap emoticons | fullscreen  preview save print | ltr rtl | anchor codesample',
                                    }}
                                    onEditorChange={(newValue, editor) => {
                                        setData("description", editor.getContent());
                                    }}
                                />
                            </Suspense>
                        </div>
                        <FormFile
                            label={'Cover Image'}
                            onChange={e => setData('cover_image', e.target.files[0])}
                            error={errors.cover_image}
                            preview={
                                isEmpty(data.cover_url) === false &&
                                <img src={data.cover_url} className="mb-1 h-24 w-full object-cover" alt="preview"/>
                            }
                        />
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