import React, { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import { usePrevious } from 'react-use';
import { Head } from '@inertiajs/react';
import { Button, Dropdown } from 'flowbite-react';
import { HiPencil, HiTrash } from 'react-icons/hi';
import { useModalState } from '@/hooks';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';
import ModalConfirm from '@/Components/ModalConfirm';
// import FormModal from './FormModal';
import SearchInput from '@/Components/SearchInput';
import { hasPermission } from '@/utils';

export default function Index(props) {
    const { query: { links, data }, auth } = props
    
    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)

    const confirmModal = useModalState()
    const formModal = useModalState()

    const toggleFormModal = (place = null) => {
        formModal.setData(place)
        formModal.toggle()
    }

    const handleDeleteClick = (place) => {
        confirmModal.setData(place)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if(confirmModal.data !== null) {
            router.delete(route('customer.destroy', confirmModal.data.id))
        }
    }

    const params = { q: search }
    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                { q: search },
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [search])

    const canCreate = false//hasPermission(auth, 'create-customer')
    const canUpdate = false//hasPermission(auth, 'update-customer')
    const canDelete = false//hasPermission(auth, 'delete-customer')

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Fastboat'}
            action={'Dock'}
        >
            <Head title="Dock" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className='flex justify-between'>
                            {canCreate && (
                                <Button size="sm" onClick={() => toggleFormModal()}>Tambah</Button>
                            )}
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
                                                Customer Name
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Order Code
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Track Name
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Quantity
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Total
                                            </th>
                                            <th scope="col" className="py-3 px-6">
                                                Payment Status
                                            </th>
                                            <th scope="col" className="py-3 px-6"/>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map(order => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={order.id}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.customer.name}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.order_code}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.track_code}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.quantity}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.quantity * order.amount}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {order.payment_status}
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
                                                            <Dropdown.Item onClick={() => toggleFormModal(order)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiPencil/> 
                                                                    <div>Ubah</div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                        {canDelete && (
                                                            <Dropdown.Item onClick={() => handleDeleteClick(order)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiTrash/> 
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
                                <Pagination links={links} params={params}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm
                modalState={confirmModal}
                onConfirm={onDelete}
            />
            {/* <FormModal
                modalState={formModal}
            /> */}
        </AuthenticatedLayout>
    );
}