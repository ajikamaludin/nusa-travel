import React, { useEffect, useState } from 'react'

import Modal from '@/Components/Modal'
import PaginationApi from '@/Components/PaginationApi'
import { formatIDR } from '@/utils'

export default function Track(props) {
    const { modalState, onItemClick } = props

    const [loading, setLoading] = useState(false)
    const [page, setPage] = useState(1)
    const [data, setData] = useState({ links: [], data: [] })

    const handleItemClick = (item) => {
        onItemClick(item)
        modalState.toggle()
    }

    const handleFetch = (page) => {
        setLoading(true)
        fetch(route('api.fasboat.track.tracks', { with_paginate: 1, page }))
            .then((res) => res.json())
            .then((res) => {
                setData(res)
            })
            .catch(() => {
                alert('Server Error: please reload')
            })
            .finally(() => {
                setLoading(false)
            })
    }

    useEffect(() => {
        if (modalState.isOpen === true) {
            handleFetch(page)
        }
    }, [modalState, page])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={modalState.toggle}
            title={'Track'}
        >
            {loading && <div className="w-full mx-auto">Loading...</div>}
            <div className={`overflow-auto ${loading && 'hidden'}`}>
                <div>
                    <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" className="py-3 px-6">
                                    Name
                                </th>
                                <th scope="col" className="py-3 px-6">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.data.map((track) => (
                                <tr
                                    className="bg-white border-b hover:bg-gray-200 dark:bg-gray-800 dark:border-gray-700"
                                    key={track.id}
                                    onClick={() => handleItemClick(track)}
                                >
                                    <td
                                        scope="row"
                                        className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {track.alternative_name}
                                    </td>
                                    <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {formatIDR(track.price)}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <div className="w-full flex items-center justify-center">
                    <PaginationApi
                        links={data}
                        page={page}
                        onPageChange={(p) => setPage(p)}
                    />
                </div>
            </div>
        </Modal>
    )
}
