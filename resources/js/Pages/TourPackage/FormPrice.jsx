import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";

import { isEmpty } from "lodash";

export default function FormModal(props) {
    const { modalState, onSave } = props
    const { data, setData, reset } = useForm({
        quantity: '',
        price: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleClose = () => {
        modalState.toggle()
        reset()
    }

    const handleSubmit = () => {
        onSave(data)
        handleClose()
    }

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Tour Package Price"}
        >
            <FormInput
                type="number"
                name="quantity"
                value={data.quantity}
                onChange={handleOnChange}
                label="Quantity"
            />
            <FormInput
                type="number"
                name="price"
                value={data.price}
                onChange={handleOnChange}
                label="Price"
            />
            <div className="flex items-center">
                <Button
                    onClick={handleSubmit}
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