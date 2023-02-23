import React, { useEffect, useRef } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";

import { isEmpty } from "lodash";
import FormFile from "@/Components/FormFile";

export default function FormModal(props) {
    const { modalState } = props
    const inputRef = useRef()

    const displayOptions = [
        {value: 0, text: 'No Display'},
        {value: 1, text: 'Main Display'},
        {value: 2, text: 'Side 1 Display'},
        {value: 3, text: 'Side 2 Display'},
    ]

    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        name: '',
        image: '',
        show_on: 0,
        path_url: null
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleReset = () => {
        modalState.setData(null)
        reset()
        clearErrors()
        inputRef.current.value = ''
    }

    const handleClose = () => {
        handleReset()
        modalState.toggle()
    }

    const handleSubmit = () => {
        const file = modalState.data
        if(file !== null) {
            post(route('gallery.update', file), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('gallery.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const file = modalState.data
        if (isEmpty(file) === false) {
            setData({
                name: file.name,
                show_on: file.show_on,
                path_url: file.path_url,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Image"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="name"
                error={errors.name}
            />
            <FormFile
                label={'Image'}
                onChange={e => setData('image', e.target.files[0])}
                error={errors.image}
                preview={
                    isEmpty(data.path_url) === false &&
                    <img src={data.path_url} className="mb-1 h-64 w-full object-cover" alt="preview"/>
                }
                inputRef={inputRef}
            />

            <div className='my-4'>
                <div className='mb-1 text-sm'>Option </div>
                <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={+data.show_on} name="show_on">
                    {displayOptions.map(op => (
                        <option key={op.value} value={op.value}>{op.text}</option>
                    ))}
                </select>
            </div>
            <div className="flex items-center">
                <Button
                    onClick={handleSubmit}
                    processing={processing} 
                >
                    Simpan
                </Button>
                <Button
                    onClick={handleClose}
                    type="secondary"
                >
                    Batal
                </Button>
            </div>
        </Modal>
    )
}