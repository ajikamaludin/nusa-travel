import React from 'react';
import { router } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import { Button, Dropdown } from 'flowbite-react';
import { HiPencil, HiTrash } from 'react-icons/hi';
import { useModalState } from '@/hooks';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';
import ModalConfirm from '@/Components/ModalConfirm';
import FormModal from './FormModal';
import { dateToString, formatDate, hasPermission } from '@/utils';

export default function Index(props) {
    const { query: { links, data }, auth } = props

    const confirmModal = useModalState()
    const formModal = useModalState()

    const toggleFormModal = (date = null) => {
        formModal.setData(date)
        formModal.toggle()
    }

    const handleDeleteClick = (date) => {
        confirmModal.setData(date)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if(confirmModal.data !== null) {
            router.delete(route('unavailable-date.destroy', confirmModal.data.id))
        }
    }

    const canCreate = hasPermission(auth, 'create-unavailable-date')
    const canUpdate = hasPermission(auth, 'update-unavailable-date')
    const canDelete = hasPermission(auth, 'delete-unavailable-date')

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Unavailable Date'}
            action={''}
            parent={route('unavailable-date.index')}
        >
            <Head title="Unavailable Date" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className='flex justify-between'>
                            {canCreate && (
                                <Button size="sm" onClick={() => toggleFormModal()}>Tambah</Button>
                            )}
                        </div>
                        <div className='overflow-auto'>
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="py-3 px-6">
                                                Date
                                            </th>
                                            <th scope="col" className="py-3 px-6"/>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map(dates => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={dates.id}>
                                                <td scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {formatDate(dates.close_date)}
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
                                                            <Dropdown.Item onClick={() => toggleFormModal(dates)}>
                                                                <div className='flex space-x-1 items-center'>
                                                                    <HiPencil/> 
                                                                    <div>Ubah</div>
                                                                </div>
                                                            </Dropdown.Item>
                                                        )}
                                                        {canDelete && (
                                                            <Dropdown.Item onClick={() => handleDeleteClick(dates)}>
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
                                <Pagination links={links}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm
                modalState={confirmModal}
                onConfirm={onDelete}
            />
            <FormModal
                modalState={formModal}
            />
        </AuthenticatedLayout>
    );
}
