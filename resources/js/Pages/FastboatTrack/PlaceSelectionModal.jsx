import React, { useState, useEffect } from "react";
import { router, usePage } from "@inertiajs/react";
import { Spinner } from "flowbite-react";
import { usePrevious } from "react-use";

import Modal from "@/Components/Modal";
import SearchInput from "@/Components/SearchInput";
import Pagination from "@/Components/Pagination";

export default function SelectionModal(props) {
    const { modalState, onItemSelected } = props
    const [loading, setLoading] = useState(false)

    const { props: { places: { data, links } } } = usePage()

    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)
    const params = { place_q: search }

    const handleItemSelected = (item) => {
        onItemSelected(item)
        modalState.toggle()
    }

    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                params,
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [search])

    useEffect(() => {
        router.on('start', () => setLoading(true))
        router.on('finish', () => setLoading(false))
    }, [])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={modalState.toggle}
            title={"Place"}
        >
            <SearchInput
                onChange={e => setSearch(e.target.value)}
                value={search}
            />
            {loading ? (
                <div className="justify-center flex flex-row w-full py-32">
                    <Spinner size="xl"/>
                </div>
            ) : (
                <div className='overflow-auto'>
                    <div>
                        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="py-3 px-6">
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {data.map(place => (
                                    <tr 
                                        className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" 
                                        key={place.id} 
                                        onClick={() => handleItemSelected(place)}
                                    >
                                        <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap hover:bg-gray-200">
                                            {place.name}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className='w-full flex items-center justify-center'>
                        <Pagination links={links} params={params}/>
                    </div>
                </div>
            )}
        </Modal>
    )
}