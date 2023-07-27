export interface GeoLocation {
    lat: number;
    lng: number;
}

export interface Address {
    street: string;
    suite: string;
    city: string;
    zipcode: string;
    geo: GeoLocation;
}

export interface Company {
    name: string;
    catchPhrase: string;
    bs: string;
}

export interface User {
    id: number;
    name: string;
    username: string;
    email: string;
    phone: string;
    website: string;
    address: Address;
    company: Company;
}

export interface Column {
    key: (keyof User);
    title: string;
}

export interface Data {
    users: User[];
    columns: Column[];
}
