import React from 'react'
import { useForm } from '@inertiajs/react'

import Modal from '@/Components/Modal'
import Button from '@/Components/Button'
import FormInput from '@/Components/FormInput'
import TextArea from '@/Components/TextArea'
import AgentSelectionInput from '../FastboatTrackAgents/SelectionInputAgent'

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, processing, errors, reset, clearErrors } =
        useForm({
            customer_id: '',
            amount: 0,
            description: '',
        })

    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === 'checkbox'
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        )
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
        post(route('deposite-agent.store'), {
            onSuccess: () => handleClose(),
        })
    }

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={'Create Deposite'}
        >
            <AgentSelectionInput
                label="Agent"
                itemSelected={data.customer_id}
                onItemSelected={(id) => setData('customer_id', id)}
                error={errors.customer_id}
            />
            <FormInput
                type="number"
                name="amount"
                value={data.amount}
                onChange={handleOnChange}
                label="Jumlah"
                error={errors.amount}
            />
            <TextArea
                name="description"
                value={data.description}
                onChange={handleOnChange}
                label="Description"
                error={errors.description}
                rows={4}
            />
            <div className="flex items-center">
                <Button onClick={handleSubmit} processing={processing}>
                    Simpan
                </Button>
                <Button onClick={handleClose} type="secondary">
                    Batal
                </Button>
            </div>
        </Modal>
    )
}
