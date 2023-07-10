import React, { useEffect, useState } from 'react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head, Link, router } from '@inertiajs/react'
import Pagination from '@/Components/Pagination'
import FormInputDateRanger from '@/Components/FormInputDateRange'
import { isEmpty } from 'lodash'
import { usePrevious } from 'react-use'

export default function Index(props) {
    const {
        dates,
        tracks,
        track_paginate: { links },
        _startDate,
        _endDate,
    } = props

    const [sded, setSded] = useState({
        startDate: _startDate,
        endDate: _endDate,
    })
    const preValue = usePrevious(sded)

    const params = { ...sded }
    useEffect(() => {
        if (preValue) {
            if (isEmpty(sded.endDate)) {
                return
            }
            router.get(
                route(route().current()),
                { ...sded },
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [sded])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Calender'}
            action={''}
        >
            <Head title="Calender" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="flex flex-row justify-between">
                            <div>
                                <Link
                                    href={route('calender.create')}
                                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                >
                                    Tambah
                                </Link>
                            </div>
                            <div>
                                <FormInputDateRanger
                                    selected={sded}
                                    onChange={setSded}
                                />
                            </div>
                        </div>
                        <div className="overflow-x-scroll">
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Track
                                            </th>
                                            {dates.map((date) => (
                                                <th
                                                    key={date.date}
                                                    scope="col"
                                                    className="py-3 px-6"
                                                >
                                                    <div className=" flex flex-col items-center">
                                                        <div>{date.today}</div>
                                                        <div>{date.date}</div>
                                                        <div>{date.month}</div>
                                                    </div>
                                                </th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {tracks.map((track) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={track.track.id}
                                            >
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {
                                                        track.track
                                                            .alternative_name
                                                    }
                                                </td>
                                                {track.avalaible.map(
                                                    (ava, index) => (
                                                        <>
                                                            {ava.text ===
                                                            'Tutup' ? (
                                                                <td
                                                                    className={`py-4 px-6 text-center bg-gray-800 text-gray-300`}
                                                                    key={index}
                                                                >
                                                                    <Link
                                                                        href={route(
                                                                            'calender.edit',
                                                                            {
                                                                                date: ava.id,
                                                                            }
                                                                        )}
                                                                    >
                                                                        {
                                                                            ava.text
                                                                        }
                                                                    </Link>
                                                                </td>
                                                            ) : (
                                                                <td
                                                                    className={`py-4 px-6 text-center`}
                                                                    key={index}
                                                                >
                                                                    {ava.text}
                                                                </td>
                                                            )}
                                                        </>
                                                    )
                                                )}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <div className="w-full flex flex-row items-center justify-center">
                                <Pagination links={links} params={params} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
