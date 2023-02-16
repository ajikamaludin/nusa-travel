import React from "react";


export default function FormFile({ label, onChange, error, preview }) {
    return (
        <div className='mt-2'>
            {label !== '' && (
                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{label}</label>
            )}
            {preview && (
                preview
            )}
            <input 
                className="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                id="small_size" 
                type="file"
                onChange={onChange}
            />
            {error && (
                <p className="mb-2 text-sm text-red-600 dark:text-red-500">{error}</p>
            )}
        </div>
    )
}