import axios from 'axios';

export class SystemWideParts {
    static async getParts() {
        const response = await axios.get('http://localhost:8000/api/system-wide-parts');
        console.log(response);
        return true;
        return response.data;
    }
}