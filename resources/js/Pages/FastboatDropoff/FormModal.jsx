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
        const dropoff = modalState.data
        if(dropoff !== null) {
            put(route('fastboat.dropoff.update', dropoff), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('fastboat.dropoff.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const dropoff = modalState.data
        if (isEmpty(dropoff) === false) {
            setData({
                name: dropoff.name,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Dropoff"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="name"
                error={errors.name}
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