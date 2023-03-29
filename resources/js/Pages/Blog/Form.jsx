import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormFile from '@/Components/FormFile';
import TextArea from '@/Components/TextArea';

const TinyEditor  = React.lazy(() => import('@/Components/TinyMCE'));

export default function Form(props) {
    const { post: content, tags } = props

    const {data, setData, post, processing, errors} = useForm({
        title: '',
        body: '',
        image: '',
        tags: [],
        is_publish: 0,
        image_url: '',
        meta_tag: ''
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleAddTag = (id) => {
        const isExist = data.tags.find(t => t.id === id)
        if (!isExist) {
            setData("tags", data.tags.concat(tags.find(i => i.id === id)))
        }
    }

    const handeRemoveTag = (id) => {
        setData("tags", data.tags.filter(i => i.id !== id))
    }

    const handleSubmit = () => {
        if(isEmpty(content) === false) {
            post(route('post.update', content.id))
            return
        }
        post(route('post.store'))
    }

    useEffect(() => {
        if(isEmpty(content) === false) {
            setData({
                title: content.title,
                body: content.body,
                is_publish: content.is_publish,
                tags: content.tags,
                image_url: content.image_url,
                meta_tag: content.meta_tag
            })
        }
    }, [content]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Blog"}
            action={"Post"}
            parent={route('post.index')}
        >
            <Head title="Post" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>Post</div>
                        <FormInput
                            name="title"
                            value={data.title}
                            onChange={handleOnChange}
                            label="Title"
                            error={errors.title}
                        />
                        <FormFile
                            label={'Cover Image'}
                            onChange={e => setData('image', e.target.files[0])}
                            error={errors.image}
                            preview={
                                isEmpty(data.image_url) === false &&
                                <img src={data.image_url} className="mb-1 h-24 w-full object-cover" alt="preview"/>
                            }
                        />
                        
                        <div className='py-4'>
                            <Suspense fallback={<div>Loading...</div>}>
                                <TinyEditor
                                    value={data.body}
                                    init={{
                                        height: 500,
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

                        <div className='mb-2'>
                            <div className='mb-1 text-sm'>Tags: </div>
                            {data.tags.map(tag => (
                            <span className="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-blue-800 bg-blue-100 rounded" key={`dis-${tag.id}`}>
                                {tag.name}
                                <button onClick={() => handeRemoveTag(tag.id)} type="button" className="inline-flex items-center p-0.5 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900">
                                    <svg aria-hidden="true" className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd"></path></svg>
                                    <span className="sr-only">Remove badge</span>
                                </button>
                            </span>
                            ))}
                        </div>

                        <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={e => handleAddTag(e.target.value)} value="">
                            <option value=""></option>
                            {tags.map(tag => (
                                <option value={tag.id} key={tag.id}>{tag.name}</option>
                            ))}
                        </select>

                        <div className='my-4'>
                            <div className='mb-1 text-sm'>Status </div>
                            <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={+data.is_publish} name="is_publish">
                                <option value={0}>Draft</option>
                                <option value={1}>Publish</option>
                            </select>
                        </div>

                        {/* <TextArea
                            name="meta_tag"
                            value={data.meta_tag}
                            onChange={handleOnChange}
                            label="MetaTag"
                            error={errors.meta_tag}
                        /> */}

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