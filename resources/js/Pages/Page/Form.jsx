import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';

const TinyEditor  = React.lazy(() => import('@/Components/TinyMCE'));

export default function Form(props) {
    const { page } = props

    const {data, setData, post, processing, errors} = useForm({
        title: '',
        body: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        post(route('page.update', page))
    }

    useEffect(() => {
        if(isEmpty(page) === false) {
            setData({
                title: page.title,
                body: page.body,
            })
        }
    }, [page]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Page"}
            action={page.title}
        >
            <Head title={page.title} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{page.title}</div>

                        <div className='py-4'>
                            <Suspense fallback={<div>Loading...</div>}>
                                <TinyEditor
                                    value={data.body}
                                    init={{
                                        height: 800,
                                        // menubar: false,
                                        menubar: 'file edit view insert format tools table help',
                                        plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
                                        toolbar_mode: 'scrolling',
                                        toolbar: 'undo redo | insertfile image media link | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | charmap emoticons | fullscreen  preview save print | ltr rtl | anchor codesample',
                                    }}
                                    onEditorChange={(newValue, editor) => {
                                        setData("body", editor.getContent());
                                    }}
                                />
                            </Suspense>
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