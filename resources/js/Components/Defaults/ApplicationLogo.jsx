import React from 'react'
import logo from '@/Assets/logo.png'
import swift from '@/Assets/swift.svg'

export default function ApplicationLogo({ className }) {
    if (import.meta.env.VITE_BUILD_OPT !== 'nusa') {
        return <img src={swift} alt="logo" className={className} />
    }
    return <img src={logo} alt="logo" className={className} />
}
