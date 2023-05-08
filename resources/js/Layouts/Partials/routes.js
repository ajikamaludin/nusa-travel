import {
    HiChartPie,
    HiUser,
    HiOutlineNewspaper,
    HiViewGrid,
    HiClipboardList,
    HiUsers,
    HiUserGroup,
    HiUserCircle,
    HiOutlineTruck,
    HiTemplate,
    HiOutlineCash,
    HiPaperAirplane,
    HiOutlineCog,
    HiCash,
    HiOutlineCube,
    HiOutlineQuestionMarkCircle,
    HiOutlineReceiptTax,
    HiCog,
    HiOutlineCalendar,
    HiOutlineTicket,
} from 'react-icons/hi'

export default [
    {
        name: 'Dashboard',
        show: true,
        icon: HiChartPie,
        route: route('dashboard'),
        active: 'dashboard',
        permission: 'view-dashboard',
    },
    {
        name: 'Fastboat',
        show: true,
        icon: HiPaperAirplane,
        items: [
            // {
            //     name: "Dropoff",
            //     show: true,
            //     icon: HiClipboardList,
            //     route: route("fastboat.dropoff.index"),
            //     active: "fastboat.dropoff.index",
            //     permission: "view-fastboat-dropoff",
            // },
            {
                name: 'Pickup',
                show: true,
                icon: HiClipboardList,
                route: route('fastboat.pickup.index'),
                active: 'fastboat.pickup.index',
                permission: 'view-fastboat-pickup',
            },
            {
                name: 'Dock',
                show: true,
                icon: HiClipboardList,
                route: route('fastboat.place.index'),
                active: 'fastboat.place.index',
                permission: 'view-fastboat-place',
            },
            {
                name: 'Fastboat',
                show: true,
                icon: HiClipboardList,
                route: route('fastboat.fastboat.index'),
                active: 'fastboat.fastboat.*',
                permission: 'view-fastboat',
            },
            {
                name: 'Track',
                show: true,
                icon: HiClipboardList,
                route: route('fastboat.track.index'),
                active: 'fastboat.track.*',
                permission: 'view-fastboat-track',
            },
            {
                name: 'Track [Globaltix]',
                show: true,
                icon: HiClipboardList,
                route: route('fastboat.globaltix.index'),
                active: 'fastboat.globaltix.*',
                permission: 'view-globaltix-to-track',
            },
            {
                name: 'Promo',
                show: true,
                icon: HiOutlineReceiptTax,
                route: route('promo.index'),
                active: 'promo.*',
                permission: 'view-promo',
            },
        ],
    },
    {
        name: 'Tour Packages',
        show: true,
        icon: HiOutlineCube,
        route: route('packages.index'),
        active: 'packages.*',
        permission: 'view-tour-package',
    },
    {
        name: 'Car Rentals',
        show: true,
        icon: HiOutlineTruck,
        route: route('car-rental.index'),
        active: 'car-rental.index',
        permission: 'view-car-rental',
    },
    {
        name: 'Customer',
        show: true,
        icon: HiUserCircle,
        route: route('customer.index'),
        active: 'customer.index',
        permission: 'view-customer',
    },
    {
        name: 'Agents',
        show: true,
        icon: HiUserGroup,
        items: [
            {
                name: 'Agent',
                show: true,
                icon: HiUserCircle,
                route: route('agent.index'),
                active: 'agent.index',
                permission: 'view-agent',
            },
            {
                name: 'Harga',
                show: true,
                icon: HiCash,
                route: route('price-agent.index'),
                active: 'price-agent.*',
                permission: 'view-price-agent',
            },
            {
                name: 'Harga [Globaltix]',
                show: true,
                icon: HiCash,
                route: route('price-agent.index'),
                active: 'price-agent.*',
                permission: 'view-price-agent',
            },
        ],
    },
    {
        name: 'Order',
        show: true,
        icon: HiOutlineCash,
        route: route('order.index'),
        active: 'order.*',
        permission: 'view-order',
    },
    {
        name: 'Close Order Date',
        show: true,
        icon: HiOutlineCalendar,
        route: route('unavailable-date.index'),
        active: 'unavailable-date.*',
        permission: 'view-unavailable-date',
    },
    {
        name: 'Blog',
        show: true,
        icon: HiOutlineNewspaper,
        items: [
            {
                name: 'Posts',
                show: true,
                icon: HiClipboardList,
                route: route('post.index'),
                active: 'post.*',
                permission: 'view-post',
            },
            {
                name: 'Tags',
                show: true,
                icon: HiClipboardList,
                route: route('tag.index'),
                active: 'tag.index',
                permission: 'view-tag',
            },
        ],
    },
    {
        name: 'Page',
        show: true,
        icon: HiTemplate,
        active: 'page.edit',
        items: [
            {
                name: 'About Us',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'aboutus' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Terms of service',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'term-of-service' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Privacy Policy',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'privacy-policy' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Cookie Policy',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'cookiepolicy' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Refund Policy',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'refundpolicy' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Disclaimer',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'disclaimer' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Schedule',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'schedule' }),
                active: '#',
                permission: 'view-page',
            },
        ],
    },
    {
        name: 'Feature Page',
        show: true,
        icon: HiTemplate,
        active: 'page.edit',
        items: [
            {
                name: 'Home',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'home' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Fastboat',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'fastboat' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Fastboat Ekajaya',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'fastboat-ekajaya' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Car Rental',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'car-rental' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Tour Package',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'tour-package' }),
                active: '#',
                permission: 'view-page',
            },
            {
                name: 'Faq',
                show: true,
                icon: HiTemplate,
                route: route('page.edit', { key: 'faq' }),
                active: '#',
                permission: 'view-page',
            },
        ],
    },
    {
        name: 'Gallery',
        show: true,
        icon: HiViewGrid,
        route: route('gallery.index'),
        active: 'gallery.index',
        permission: 'view-gallery',
    },
    {
        name: 'Faq',
        show: true,
        icon: HiOutlineQuestionMarkCircle,
        route: route('faq.index'),
        active: 'faq.index',
        permission: 'view-faq',
    },
    {
        name: 'Setting',
        show: true,
        icon: HiOutlineCog,
        items: [
            {
                name: 'General',
                show: true,
                icon: HiOutlineCog,
                route: route('setting.general'),
                active: 'setting.general',
                permission: 'view-setting',
            },
            {
                name: 'Payment',
                show: true,
                icon: HiCash,
                route: route('setting.payment'),
                active: 'setting.payment',
                permission: 'view-setting',
            },
            {
                name: 'Nusa Integration',
                show: true,
                icon: HiCog,
                route: route('setting.ekajaya'),
                active: 'setting.ekajaya',
                permission: 'view-setting',
            },
            {
                name: 'GlobalTix',
                show: true,
                icon: HiOutlineTicket,
                route: route('setting.globaltix'),
                active: 'setting.globaltix',
                permission: 'view-setting',
            },
        ],
    },
    {
        name: 'User',
        show: true,
        icon: HiUser,
        items: [
            {
                name: 'Roles',
                show: true,
                icon: HiUserGroup,
                route: route('roles.index'),
                active: 'roles.*',
                permission: 'view-role',
            },
            {
                name: 'Users',
                show: true,
                icon: HiUsers,
                route: route('user.index'),
                active: 'user.index',
                permission: 'view-user',
            },
        ],
    },
]
