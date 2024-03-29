import React, { useEffect, useState } from 'react'
import { router } from '@inertiajs/react'
import { usePrevious } from 'react-use'
import { Head } from '@inertiajs/react'
import { Button, Dropdown } from 'flowbite-react'
import { HiTrash } from 'react-icons/hi'
import { useModalState } from '@/hooks'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Pagination from '@/Components/Pagination'
import ModalConfirm from '@/Components/ModalConfirm'
import FormModal from './FormModal'
import SearchInput from '@/Components/SearchInput'
import { formatIDR, hasPermission } from '@/utils'

export default function Index(props) {
    const {
        query: { links, data },
        auth,
    } = props

    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)

    const confirmModal = useModalState()
    const formModal = useModalState()

    const toggleFormModal = (history = null) => {
        formModal.setData(history)
        formModal.toggle()
    }

    const handleDeleteClick = (history) => {
        confirmModal.setData(history)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if (confirmModal.data !== null) {
            router.delete(route('deposite-agent.destroy', confirmModal.data.id))
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

    const canCreate = hasPermission(auth, 'create-deposite-agent')
    const canDelete = hasPermission(auth, 'delete-deposite-agent')

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={'Deposite'}
            action={'Agent'}
            parent={route(route().current())}
        >
            <Head title="Deposite" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8 ">
                    <div className="p-6 overflow-hidden shadow-sm sm:rounded-lg bg-gray-200 dark:bg-gray-800 space-y-4">
                        <div className="flex justify-between">
                            {canCreate && (
                                <Button
                                    size="sm"
                                    onClick={() => toggleFormModal()}
                                >
                                    Tambah
                                </Button>
                            )}
                            <div className="flex items-center">
                                <SearchInput
                                    onChange={(e) => setSearch(e.target.value)}
                                    value={search}
                                />
                            </div>
                        </div>
                        <div className="overflow-auto">
                            <div>
                                <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Agent Name
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Debit
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Credit
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            >
                                                Description
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3 px-6"
                                            />
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.map((history) => (
                                            <tr
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                key={history.id}
                                            >
                                                <td
                                                    scope="row"
                                                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {history.customer.name}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {formatIDR(history.debit)}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {formatIDR(history.credit)}
                                                </td>
                                                <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {history.description}
                                                </td>
                                                <td className="py-4 px-6 flex justify-end">
                                                    <Dropdown
                                                        label={'Opsi'}
                                                        floatingArrow={true}
                                                        arrowIcon={true}
                                                        dismissOnClick={true}
                                                        size={'sm'}
                                                    >
                                                        {canDelete && (
                                                            <Dropdown.Item
                                                                onClick={() =>
                                                                    handleDeleteClick(
                                                                        history
                                                                    )
                                                                }
                                                            >
                                                                <div className="flex space-x-1 items-center">
                                                                    <HiTrash />
                                                                    <div>
                                                                        Hapus
                                                                    </div>
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
                            <div className="w-full flex items-center justify-center">
                                <Pagination links={links} params={params} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalConfirm modalState={confirmModal} onConfirm={onDelete} />
            <FormModal modalState={formModal} />
        </AuthenticatedLayout>
    )
}
