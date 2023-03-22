import React, { useEffect } from "react";
import { isEmpty } from "lodash";
import { useForm } from "@inertiajs/react";

import Modal from "@/Components/Modal";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";
import PlaceSelectionInput from '../FastboatPlace/SelectionInput';
import CarRentalSelectionInput from '../CarRental/SelectionInput';

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
        name: '',
        source_id: '',
        car_rental_id: '',
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
        const pickup = modalState.data
        if(pickup !== null) {
            put(route('fastboat.pickup.update', pickup), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('fastboat.pickup.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const pickup = modalState.data
        if (isEmpty(pickup) === false) {
            setData({
                name: pickup.name,
                source_id: pickup.source_id,
                car_rental_id: pickup.car_rental_id,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Pickup"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="name"
                error={errors.name}
            />
            <PlaceSelectionInput
                label="Origin"
                itemSelected={data.source_id}
                onItemSelected={(place) => setData('source_id', place.id)}
                error={errors.source_id}
            />
            <CarRentalSelectionInput
                label="Car Rental"
                itemSelected={data.car_rental_id}
                onItemSelected={(id) => setData('car_rental_id', id)}
                error={errors.car_rental_id}
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