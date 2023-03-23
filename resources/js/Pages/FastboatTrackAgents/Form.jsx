import React, { useEffect } from 'react';
import { isEmpty } from 'lodash';

import { Head, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import FormInput from '@/Components/FormInput';
import AgentSelectionInput from "../FastboatTrackAgents/SelectionInput";
import FastboatTrackSelectionInput from "./SelectionInputTrack";

export default function Form(props) {
    const { group } = props

    const { data, setData, post, put, processing, errors } = useForm({
        customer_id: '',
        fastboat_track_group_id: '',
        tracks: [],
    })

    const handleChangeTrackValue = (name, value, index) => {
        setData("tracks", data.tracks.map((track, i) => {
            if (i === index) {
                track[name] = value
            }
            return track
        }))
    }

    const handleSelectFastboatTrack = (track) => {
        if (track) {
            setData({
                ...data,
                fastboat_track_group_id: track.id,
                tracks: track.tracks,
            })
        }
    }

    const handleSelectCustomer = (id) => {
        if (id) {
            setData({
                customer_id: id,
                fastboat_track_group_id: null,
                tracks: [],
            })
        }
    }

    const handleSubmit = () => {
        if (isEmpty(group) === false) {
            put(route('price-agent.track.update', group))
            return
        }
        post(route('price-agent.track.store'))
    }

    useEffect(() => {
        if (isEmpty(group) === false) {
            setData({
                customer_id: group.customer_id,
                fastboat_track_group_id: group.fastboat_track_group_id,
                tracks: group.tracks,
            })
        }
    }, [group])


    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Agents'}
            action={'Harga Agent'}
            parent={route('price-agent.index')}
        >
            <Head title={'Form'} />
            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{"Harga Agent"}</div>
                        {isEmpty(group) === false ? (
                            <div>
                                <FormInput 
                                    label="Agent"
                                    readOnly={true}
                                    value={group.customer.name}
                                />
                                <FormInput 
                                    label="Fastboat Track"
                                    readOnly={true}
                                    value={`${group.track_group.name} (${group.track_group.fastboat.name})`}
                                />
                            </div>
                        ) : (
                            <div>
                                <AgentSelectionInput
                                    label="Agent"
                                    itemSelected={data.customer_id}
                                    onItemSelected={handleSelectCustomer}
                                    error={errors.customer_id}
                                />
                                <FastboatTrackSelectionInput
                                    label="Fastboat Track"
                                    itemSelected={data.fastboat_track_group_id}
                                    customer_id={data.customer_id}
                                    onItemSelected={(item) => handleSelectFastboatTrack(item)}
                                    error={errors.fastboat_id}
                                />
                            </div>
                            )}
                        <p className='mt-4'>Track</p>
                        <div className='border-2 rounded-lg p-2'>
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="py-3 px-6">
                                            Source - Destination
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Departure At
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Arrival At
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Price
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Publish
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {isEmpty(group) === false ? (
                                        <>
                                        {data.tracks.map((track, index) => (
                                            <tr className="bg-white border-b" key={index}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track?.track.source?.name} - {track?.track.destination?.name}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track.track.arrival_time}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track.track.departure_time}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    <FormInput
                                                        type="number"
                                                        value={(+track.price).toFixed(0)}
                                                        onChange={e => handleChangeTrackValue("price", e.target.value, index)}
                                                    />
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                        {+track?.track.is_publish === 1 ? 'Yes' : 'No'}
                                                </td>
                                            </tr>
                                        ))}
                                        </>
                                    ) : (
                                        <>
                                        {data.tracks.map((track, index) => (
                                            <tr className="bg-white border-b" key={index}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track?.source?.name} - {track?.destination?.name}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track.arrival_time}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {track.departure_time}
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    <FormInput
                                                        type="number"
                                                        value={(+track.price).toFixed(0)}
                                                        onChange={e => handleChangeTrackValue("price", e.target.value, index)}
                                                    />
                                                </td>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                        {+track?.is_publish === 1 ? 'Yes' : 'No'}
                                                </td>
                                            </tr>
                                        ))}
                                        </>
                                    )}
                                </tbody>
                            </table>
                        </div>

                        <div className='mt-8'>
                            <Button
                                onClick={handleSubmit}
                                processing={processing}
                            >
                                Simpan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}