import React, { useEffect, useRef } from 'react'
import { useForm } from '@inertiajs/react'
import { isEmpty } from 'lodash'

import Modal from '@/Components/Modal'
import Button from '@/Components/Button'
import FormInput from '@/Components/FormInput'
import FastboatTrackSelectionInput from './SelectionInputTrack'
import AgentSelectionInput from '../FastboatTrackAgents/SelectionInputAgent'

export default function FormModal(props) {
    const { modalState } = props

    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            fastboat_track_id: null,
            customer_id: null,
            price: null,
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
        const track = modalState.data
        if (track !== null) {
            put(route('globaltix-price-agent.update', track), {
                onSuccess: () => handleClose(),
            })
            return
        }
        post(route('globaltix-price-agent.store'), {
            onSuccess: () => handleClose(),
        })
    }

    useEffect(() => {
        const track = modalState.data
        if (isEmpty(track) === false) {
            setData({
                fastboat_track_id: track.fastboat_track_id,
                customer_id: track.customer_id,
                price: parseFloat(track.price).toFixed(0),
            })
            return
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={'Harga Agent [Globaltix]'}
        >
            <FastboatTrackSelectionInput
                label="Track [Globaltix]"
                itemSelected={data.fastboat_track_id}
                onItemSelected={(id) => setData('fastboat_track_id', id)}
                error={errors.fastboat_track_id}
            />
            <AgentSelectionInput
                label="Agent"
                itemSelected={data.customer_id}
                onItemSelected={(id) => setData('customer_id', id)}
                error={errors.customer_id}
            />
            <FormInput
                type="number"
                name="price"
                value={data.price}
                onChange={handleOnChange}
                label="Harga"
                error={errors.price}
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
