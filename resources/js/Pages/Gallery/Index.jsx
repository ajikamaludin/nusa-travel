import React, { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import { usePrevious } from 'react-use';
import { Head } from '@inertiajs/react';
import { Button, Dropdown } from 'flowbite-react';
import { HiEye, HiPencil, HiTrash } from 'react-icons/hi';
import { useModalState } from '@/hooks';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';
import ModalConfirm from '@/Components/ModalConfirm';
import FormModal from './FormModal';
import SearchInput from '@/Components/SearchInput';
import { hasPermission } from '@/utils';

export default function Index(props) {
    const { query: { links, data }, auth } = props
    
    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)

    const confirmModal = useModalState()
    const formModal = useModalState()

    const toggleFormModal = (file = null) => {
        formModal.setData(file)
        formModal.toggle()
    }

    const handleDeleteClick = (file) => {
        confirmModal.setData(file)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if(confirmModal.data !== null) {
            router.delete(route('gallery.destroy', confirmModal.data.id))
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

    const canCreate = hasPermission(auth, 'create-gallery')
    const canUpdate = hasPermission(auth, 'update-gallery')
    const canDelete = hasPermission(auth, 'delete-gallery')

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Gallery'}
            action={''}
            parent={route(route().current())}
        >
            <Head title="Gallery" />

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
                            <div className='grid grid-cols-2 md:grid-cols-4 gap-2 mb-5'>
                                {data.map(file => (
                                    <figure className="relative transition-all duration-300 cursor-pointer filter" key={file.id}>
                                        <img className="rounded-lg object-cover w-full h-48" src={file.path_url} alt={file.name}/>
                                        <figcaption className="absolute px-4 text-xl text-white outlined-black bottom-6">
                                            <p>{file.name}</p>
                                        </figcaption>
                                        <div className='absolute bottom-0 opacity-0 transition-opacity hover:opacity-100 w-full h-full'>
                                            <div className='absolute bottom-5 right-5 flex flex-row gap-1'>
                                                {canUpdate && (
                                                    <div className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2' onClick={() => toggleFormModal(file)}>
                                                        <HiPencil/>
                                                    </div>
                                                )}
                                                {canDelete && (
                                                    <div className='text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2' onClick={() => handleDeleteClick(file)}>
                                                        <HiTrash/>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </figure>
                                ))}
                            </div>
                            {data.length <= 0 && (
                                <div className='w-full h-80 flex justify-center items-center'>
                                    No Image Found
                                </div>
                            )}
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
            <FormModal
                modalState={formModal}
            />
        </AuthenticatedLayout>
    );
}
