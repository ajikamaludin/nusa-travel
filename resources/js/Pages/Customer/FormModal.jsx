import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";

import { isEmpty } from "lodash";

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
        name: '',
        email: '',
        phone: '',
        address: '',
        nation: '',
        national_id: '',
        password: ''
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleReset = () => {
        modalState.setData(null)
        reset()
        clearErrors()
    }

    const handleClose = () => {
        handleReset()
        modalState.toggle()
    }

    const handleSubmit = () => {
        const customer = modalState.data
        if(customer !== null) {
            put(route('customer.update', customer), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('customer.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const customer = modalState.data
        if (isEmpty(customer) === false) {
            setData({
                name: customer.name,
                email: customer.email,
                phone: customer.phone,
                address: customer.address,
                nation: customer.nation,
                national_id: customer.national_id,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Customer"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="name"
                error={errors.name}
            />
            <FormInput
                name="email"
                value={data.email}
                onChange={handleOnChange}
                label="email"
                error={errors.email}
            />
            <FormInput
                name="phone"
                value={data.phone}
                onChange={handleOnChange}
                label="phone"
                error={errors.phone}
            />
            <FormInput
                name="address"
                value={data.address}
                onChange={handleOnChange}
                label="address"
                error={errors.address}
            />
            <div className='my-4'>
                <div className='mb-1 text-sm'>Nation :</div>
                <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={data.nation} name="nation">
                    {['WNI', 'WNA'].map(p => (
                        <option key={p} value={p}>{p}</option>
                    ))}
                </select>
            </div>
            <FormInput
                name="national_id"
                value={data.national_id}
                onChange={handleOnChange}
                label="national_id"
                error={errors.national_id}
            />
            <FormInput
                type="password"
                name="password"
                value={data.password}
                onChange={handleOnChange}
                label="password"
                error={errors.password}
                placeholder="leave blank to unchange"
            />
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