import React from 'react'
import DatePicker from 'react-datepicker'
import { converToDate, dateToString } from '@/utils'

export default function FormInputDateRanger({
    selected,
    onChange,
    label = '',
    error,
    placeholder = '',
}) {
    return (
        <div>
            {label !== '' && (
                <label
                    htmlFor={label}
                    className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                    {label}
                </label>
            )}
            <DatePicker
                id={label}
                selected={converToDate(selected.startDate)}
                onChange={(date) => {
                    let startDate = dateToString(date[0])
                    let endDate = null
                    if (date[1] != null) {
                        endDate = dateToString(date[1])
                    }
                    onChange({ startDate, endDate })
                }}
                startDate={converToDate(selected.startDate)}
                endDate={converToDate(selected.endDate)}
                closeOnScroll={true}
                shouldCloseOnSelect={true}
                dateFormat="dd/MM/yyyy"
                className={`mb-2 bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700  dark:placeholder-gray-400 dark:text-white  ${
                    error
                        ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500'
                        : 'border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500'
                }`}
                nextMonthButtonLabel=">"
                previousMonthButtonLabel="<"
                nextYearButtonLabel=">"
                previousYearButtonLabel="<"
                placeholderText={placeholder}
                selectsRange
            />
            {error && (
                <p className="mb-2 text-sm text-red-600 dark:text-red-500">
                    {error}
                </p>
            )}
        </div>
    )
}
