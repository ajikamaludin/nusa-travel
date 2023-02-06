import moment from "moment";

export const formatDate = (date) => {
    return moment(date).format("DD/MM/yyyy");
};

export const formatDateTime = (date) => {
    return moment(date).format("DD/MM/yyyy HH:mm:ss");
};

export function formatIDR(amount) {
    const idFormatter = new Intl.NumberFormat("id-ID",{
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
    return idFormatter.format(amount);
}

export const formatIDDate = (date) => {
    const month = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    date = new Date(date);

    return `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()}`;
};

export const hasPermission = (auth, permission) => {
    const { user } = auth
    if (+user.role === null) {
        return true;
    }

    let has = user.role.permissions.find(item => item.name === permission)

    if(has) {
        return true
    }
    return false;
}