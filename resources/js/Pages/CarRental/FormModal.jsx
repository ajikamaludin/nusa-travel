import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";

import { isEmpty } from "lodash";
import TextArea from "@/Components/TextArea";
import FormFile from "@/Components/FormFile";

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
        name: '',
        price: '',
        description: '',
        capacity: '',
        luggage: '',
        car_owned: '',
        transmission: '',
        image: '',
        image_url: '',
        is_publish: 1,
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
        const car = modalState.data
        if(car !== null) {
            put(route('car-rental.update', car), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('car-rental.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const car = modalState.data
        if (isEmpty(car) === false) {
            setData({
                name: car.name,
                price: (+car.price).toFixed(0),
                description: car.description,
                capacity: car.capacity,
                luggage: car.luggage,
                car_owned: car.car_owned,
                transmission: car.transmission,
                image_url: car.image_url,
                is_publish: car.is_publish,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Car Rental"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="Name"
                error={errors.name}
            />
            <FormInput
                type="number"
                name="price"
                value={data.price}
                onChange={handleOnChange}
                label="Price"
                error={errors.price}
            />
            <FormInput
                type="number"
                name="capacity"
                value={data.capacity}
                onChange={handleOnChange}
                label="Seats"
                error={errors.capacity}
            />
            <FormInput
                type="number"
                name="luggage"
                value={data.luggage}
                onChange={handleOnChange}
                label="Luggage"
                error={errors.luggage}
            />
            <FormInput
                type="number"
                name="car_owned"
                value={data.car_owned}
                onChange={handleOnChange}
                label="Car Owned"
                error={errors.car_owned}
            />
            <div className='my-4'>
                <div className='mb-1 text-sm'>Transmision</div>
                <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={data.transmission} name="transmission">
                    {['', 'Manual', 'Automatic', 'Hybrid'].map(p => (
                        <option key={p} value={p}>{p}</option>
                    ))}
                </select>
            </div>
            <div className='my-4'>
                <div className='mb-1 text-sm'>Status </div>
                <select className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onChange={handleOnChange} value={+data.is_publish} name="is_publish">
                    <option value={0}>Unpublish</option>
                    <option value={1}>Publish</option>
                </select>
            </div>
            <FormFile
                label={'Car Image'}
                onChange={e => setData('image', e.target.files[0])}
                error={errors.image}
                preview={
                    isEmpty(data.image_url) === false &&
                    <img src={data.image_url} className="mb-1 max-h-32 w-full object-contain" alt="preview"/>
                }
            />
            <TextArea
                name="description"
                value={data.description}
                onChange={handleOnChange}
                label="Description"
                error={errors.description}
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