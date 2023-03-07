import React, { useEffect } from 'react';
import { isEmpty } from 'lodash';

import { Head, router, useForm } from '@inertiajs/react';
import { useModalState } from '@/hooks';
import { generateTrack } from './helper';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';
import FormInputTime from '@/Components/FormInputTime';
import Checkbox from '@/Components/Checkbox';
import FormInput from '@/Components/FormInput';
import FastboatSelectionInput from "../Fastboat/SelectionInput";
import PlaceSelectionModal from "./PlaceSelectionModal";
import { toast } from 'react-toastify';

export default function Form(props) {
    const { group } = props

    const placeSelectionModal = useModalState()

    const {data, setData, post, put, processing, errors} = useForm({
        fastboat_id: '',
        places: [],
        tracks: [],
    })

    const addPlace = (place) => {
        const isExists = data.places.find(p => p.place.id === place.id)
        if(!isExists) {
            let places = data.places.concat({
                place: place,
                fastboat_place_id: place.id,
                order: (data.places.length + 1)
            })
            let tracks = generateTrack(places, data.tracks)
            setData({ ...data, places, tracks })
        }
    }

    const removePlace = (index) => {
        let places = data.places.filter((_, i) => i !== index)
        places = places.map((place, i) => {
            return {
                ...place,
                order: (i + 1)
            }
        })
        let tracks = generateTrack(places, data.tracks)
        setData({ ...data, places, tracks })
    }

    const handleChangeTrackValue = (name, value, index) => {
        setData("tracks", data.tracks.map((track, i) => {
            if(i === index) {
                track[name] = value
            }
            return track
        }))
    }

    const handleSubmit = () => {
        if(data.places.length <= 1) {
            toast.error("Place must be more than 1")
            return
        }
        if(isEmpty(group) === false) {
            put(route('fastboat.track.update', group))
            return
        }
        post(route('fastboat.track.store'))
    }

    useEffect(() => {
        if(isEmpty(group) === false) {
            setData({
                fastboat_id: group.fastboat_id,
                places: group.places,
                tracks: group.tracks,
            })
        }
    }, [group]) 

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Fastboat"}
            action={"Track"}
        >
            <Head title={"Form"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className='text-xl font-bold mb-4'>{"Fastboat Track"}</div>
                        <FastboatSelectionInput
                            label="Fastboat"
                            itemSelected={data.fastboat_id}
                            onItemSelected={(id) => setData('fastboat_id', id)}
                            error={errors.fastboat_id}
                        />

                        <p className='mt-4'>Place</p>
                        <div className='border-2 rounded-lg p-2'>
                            <Button size="sm" onClick={placeSelectionModal.toggle}>Tambah</Button>
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="py-3 px-6">
                                            Dock
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Order
                                        </th>
                                        <th/>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.places.map((place, index) => (
                                        <tr className="bg-white border-b" key={place.order}>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {place.place.name}
                                            </td>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {place.order}
                                            </td>
                                            <td className="py-4 px-6 text-red-500 font-extrabold"
                                                onClick={() => removePlace(index)}
                                            >
                                                X
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        <p className='mt-4'>Track</p>
                        <div className='border-2 rounded-lg p-2'>
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="py-3 px-6">
                                            Source - Destination
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Arrival At
                                        </th>
                                        <th scope="col" className="py-3 px-6">
                                            Departure At
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
                                    {data.tracks.map((track, index) => (
                                        <tr className="bg-white border-b" key={index}>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {track.source.name} - {track.destination.name}
                                            </td>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                <FormInputTime
                                                    value={track.arrival_time}
                                                    onChange={d => handleChangeTrackValue("arrival_time", d, index)}
                                                />
                                            </td>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                <FormInputTime
                                                    value={track.departure_time}
                                                    onChange={d => handleChangeTrackValue("departure_time", d, index)}
                                                />
                                            </td>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                <FormInput
                                                    type="number"
                                                    value={(+track.price).toFixed(0)}
                                                    onChange={e => handleChangeTrackValue("price", e.target.value, index)}
                                                />
                                            </td>
                                            <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                <Checkbox
                                                    value={+track.is_publish === 1}
                                                    onChange={e => handleChangeTrackValue("is_publish", e.target.checked ? 1 : 0, index)}
                                                />
                                            </td>
                                        </tr>
                                    ))}
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
            <PlaceSelectionModal modalState={placeSelectionModal} onItemSelected={addPlace}/>
        </AuthenticatedLayout>
    );
}