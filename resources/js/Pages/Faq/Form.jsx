import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormInput from '@/Components/FormInput';

const TinyEditor  = React.lazy(() => import('@/Components/TinyMCE'));

export default function Form(props) {
    const { faq } = props

    const {data, setData, post, processing, errors} = useForm({
        question: '',
        answer: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleSubmit = () => {
        if(isEmpty(faq) === false) {
            post(route('faq.update', faq))
            return
        }
        post(route('faq.store'))
    }

    useEffect(() => {
        if(isEmpty(faq) === false) {
            setData({
                question: faq.question,
                answer: faq.answer,
            })
        }
    }, [faq]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Faq"}
            action={"Question"}
            parent={route('faq.index')}
        >
            <Head title={"Form"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{"Faq"}</div>
                        <FormInput
                            name="question"
                            value={data.question}
                            onChange={handleOnChange}
                            label="Question"
                            error={errors.question}
                        />
                        <div className='py-4'>
                            <Suspense fallback={<div>Loading...</div>}>
                                <label>Answer</label>
                                <TinyEditor
                                    value={data.answer}
                                    init={{
                                        height: 800,
                                        // menubar: false,
                                        menubar: 'file edit view insert format tools table help',
                                        plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
                                        toolbar_mode: 'scrolling',
                                        toolbar: 'undo redo | insertfile image media link | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | charmap emoticons | fullscreen  preview save print | ltr rtl | anchor codesample',
                                    }}
                                    onEditorChange={(newValue, editor) => {
                                        setData("answer", editor.getContent());
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