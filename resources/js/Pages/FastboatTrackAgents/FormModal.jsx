import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import PlaceSelectionInput from "../FastboatPlace/SelectionInput";

import { isEmpty } from "lodash";
import FormInput from "@/Components/FormInput";
import FormInputTime from "@/Components/FormInputTime";
import Checkbox from "@/Components/Checkbox";

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
        fastboat_source_id: null,
        fastboat_destination_id: null,
        price: '',
        capacity: '',
        arrival_time: '0:0',
        departure_time: '0:0',
        is_publish: '0'
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
        const track = modalState.data
        if(track !== null) {
            put(route('fastboat.track.update', track), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('fastboat.track.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const track = modalState.data
        if (isEmpty(track) === false) {
            setData({
                fastboat_source_id: track.fastboat_source_id,
                fastboat_destination_id: track.fastboat_destination_id,
                price: (+track.price).toFixed(0),
                capacity: track.capacity,
                arrival_time: track.arrival_time,
                departure_time: track.departure_time,
                is_publish: track.is_publish,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Track"}
        >
            <PlaceSelectionInput
                label="Source"
                itemSelected={data.fastboat_source_id}
                onItemSelected={(id) => setData('fastboat_source_id', id)}
                error={errors.fastboat_source_id}
            />
            <PlaceSelectionInput
                label="Destination"
                itemSelected={data.fastboat_destination_id}
                onItemSelected={(id) => setData('fastboat_destination_id', id)}
                error={errors.fastboat_destination_id}
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
                label="Capacity"
                error={errors.capacity}
            />
            <FormInputTime
                label="Arrival Time"
                value={data.arrival_time}
                onChange={d => setData("arrival_time", d)}
                error={errors.arrival_time}
            />
            <FormInputTime
                label="Departure Time"
                value={data.departure_time}
                onChange={d => setData("departure_time", d)}
                error={errors.departure_time}
            />
            <Checkbox
                label='Open'
                value={+data.is_publish === 1}
                onChange={handleOnChange}
                name='is_publish'
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