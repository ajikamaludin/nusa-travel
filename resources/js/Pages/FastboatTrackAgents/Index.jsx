import React, { useEffect, useState } from 'react';
import { Link, router, Head } from '@inertiajs/react';
import { usePrevious } from 'react-use';
import { Dropdown } from 'flowbite-react';
import { HiPencil, HiTrash } from 'react-icons/hi';
import { useModalState } from '@/hooks';
import { hasPermission } from '@/utils';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';
import ModalConfirm from '@/Components/ModalConfirm';
import SearchInput from '@/Components/SearchInput';
import CustomerSelectionInput from '../Customer/SelectionInput';

export default function Index(props) {
    const { query: { links, data }, auth } = props

    const [agent, setAgent] = useState(null)
    const [search, setSearch] = useState('')
    const preValue = usePrevious({search, agent})

    const confirmModal = useModalState()

    const handleDeleteClick = (track) => {
        confirmModal.setData(track)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if (confirmModal.data !== null) {
            router.delete(route('price-agent.track.destroy', confirmModal.data.id))
        }
    }

    const params = { q: search, agent: agent }
    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                { q: search, agent: agent },
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [search, agent])

    const canCreate = hasPermission(auth, 'create-price-agent')
    const canUpdate = hasPermission(auth, 'update-price-agent')
    const canDelete = hasPermission(auth, 'delete-price-agent')

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Agents'}
            action={'Harga Agent'}
            parent={route('price-agent.index')}
        >
            <Head title="Harga Agent" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className='flex justify-between'>
                            <div className='flex flex-row justify-between space-x-2'>
                                {canCreate && (
                                    <Link href={route("price-agent.track.create")} className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5'>Tambah</Link>
                                )}
                                <div>
                                    <CustomerSelectionInput
                                        placeholder="Filter: agent"
                                        itemSelected={agent}
                                        onItemSelected={(id) => setAgent(id)}
                                    />
                                </div>
                            </div>
                            <div className="flex items-center">
                                <SearchInput
                                    onChange={e => setSearch(e.target.value)}
                                    value={search}
                                />
                            </div>
                        </div>
                        <div className='overflow-auto'>
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="py-3 px-6">
                                                Nama Agent
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Track
                                            </th>
                                            <th scope="col" className="py-3 px-6" />
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map((group,index) => (
                                            <tr className="bg-white border-b" key={index+1}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {group?.customer?.name}
                                                </td>

                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {group?.track_group?.name} ( {group?.track_group?.fastboat?.name} )
                                                </td>
                                                <td className="py-4 px-6 flex justify-end">
                                                    <Dropdown
                                                        label={"Opsi"}
                                                        floatingArrow={true}
                                                        arrowIcon={true}
                                                        dismissOnClick={true}
                                                        size={'sm'}
                                                    >
                                                        {canUpdate && (
                                                            <Dropdown.Item>
                                                                <Link href={route('price-agent.trackagent.edit', group)} className='flex space-x-1 items-center'>
                                                                    <HiPencil />
                                                                    <div>Ubah</div>
                                                                </Link>
                                                            </Dropdown.Item>
                                                        )}
                                                        {canDelete && (
                                                            <Dropdown.Item onClick={() => handleDeleteClick(group)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiTrash />
                                                                    <div>Hapus</div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                    </Dropdown>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <div className='w-full flex items-center justify-center'>
                                <Pagination links={links} params={params} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm
                modalState={confirmModal}
                onConfirm={onDelete}
            />
        </AuthenticatedLayout>
    );
}
