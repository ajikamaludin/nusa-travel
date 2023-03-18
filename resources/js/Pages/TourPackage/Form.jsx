import React, { useEffect, Suspense } from 'react';
import { isEmpty } from 'lodash';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormFile from '@/Components/FormFile';
import FormPrice from './FormPrice';
import TextArea from '@/Components/TextArea';
import { HiPlusCircle, HiTrash } from 'react-icons/hi';
import { FileUploader } from './helper';
import { useModalState } from '@/hooks';
import { formatIDR } from '@/utils';

const TinyEditor  = React.lazy(() => import('@/Components/TinyMCE'));

export default function Form(props) {
    const { packages, csrf_token } = props

    const formModal = useModalState()

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        title: '',
        body: '',
        image: '',
        price: '',
        is_publish: 0,
        image_url: '',
        meta_tag: '',
        images: [],
        prices: []
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleAddImage = (res) => {
        setData("images", data.images.concat({
            file_id: res.id,
            name: res.name,
            url: res.url,
        }))
    }

    const handleRemoveImage = (index) => {
        setData("images", data.images.filter((p, i) => i !== index))
    }

    const handleAddPrice = (price) => {
        setData("prices", data.prices.concat({
            quantity: price.quantity,
            price: price.price,
        }))
    }

    const handleRemovePrice = (index) => {
        setData("prices", data.prices.filter((p, i) => i !== index))
    }

    const handleSubmit = () => {
        if(isEmpty(packages) === false) {
            post(route('packages.update', packages.id))
            return
        }
        post(route('packages.store'))
    }

    useEffect(() => {
        if(isEmpty(packages) === false) {
            setData({
                name: packages.name,
                title: packages.title,
                body: packages.body,
                price: (+packages.price).toFixed(0),
                is_publish: packages.is_publish,
                image_url: packages.image_url,
                meta_tag: packages.meta_tag,
                images: packages.images,
                prices: packages.prices,
            })
        }
    }, [packages]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Tour Packages"}
            action={"Form"}
            parent={route('packages.index')}
        >
            <Head title="Tour Package" />
            <div className="mx-auto sm:px-6 lg:px-8">
                <div className="p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                    <div className='text-xl font-bold mb-4'>Tour Package</div>
                    <FormInput
                        name="name"
                        value={data.name}
                        onChange={handleOnChange}
                        label="Name"
                        error={errors.name}
                    />
                    <FormInput
                        name="title"
                        value={data.title}
                        onChange={handleOnChange}
                        label="Title"
                        error={errors.title}
                    />
                    <FormInput
                        type="number"
                        name="price"
                        value={data.price}
                        onChange={handleOnChange}
                        label="Display Price"
                        error={errors.price}
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
                    <div className='mb-2 w-full flex-none'>
                        <label>Images </label>
                        <div className='flex flex-nowrap space-x-1 overflow-x-scroll'>
                            {data.images.map((img, i) => (
                                <img src={img.url} className='w-44 max-h-32 object-cover hover:opacity-70' alt={img.name} key={img.file_id} onClick={() => handleRemoveImage(i)}/>
                            ))}
                            <div 
                                className='w-44 bg-slate-200 flex-none flex items-center justify-center' 
                                style={{
                                    minHeight: '6rem',
                                }}
                                onClick={() => FileUploader(handleAddImage, csrf_token)}
                            >
                                <HiPlusCircle className='w-10 h-10'/>
                            </div>
                        </div>
                    </div>
                    
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
                    <div className='my-4'>
                        <div className='w-full flex mb-2'>
                            <div 
                                className='text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 px-4 py-1'
                                onClick={formModal.toggle}
                            >
                                Add
                            </div>
                        </div>
                        <div className="relative overflow-x-auto">
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="px-6 py-3">
                                            Quantity
                                        </th>
                                        <th scope="col" className="px-6 py-3">
                                            Price
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.prices.map((price, index) => (
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={index}>
                                            <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {price.quantity}
                                            </th>
                                            <td className="px-6 py-4">
                                                {formatIDR(price.price)}
                                            </td>
                                            <td onClick={() => handleRemovePrice(index)}>
                                                <HiTrash/>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div className='my-4'>
                        <div className='mb-1 text-sm'>Status </div>
                        <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={+data.is_publish} name="is_publish">
                            <option value={0}>Draft</option>
                            <option value={1}>Publish</option>
                        </select>
                    </div>

                    <TextArea
                        name="meta_tag"
                        value={data.meta_tag}
                        onChange={handleOnChange}
                        label="MetaTag"
                        error={errors.meta_tag}
                    />

                    <div className='mt-8'>
                        <Button
                            onClick={handleSubmit}
                            processing={processing} 
                        >
                            Save
                        </Button>
                    </div>
                </div>
            </div>
            <FormPrice
                modalState={formModal}
                onSave={handleAddPrice}
            />
        </AuthenticatedLayout>
    );
}