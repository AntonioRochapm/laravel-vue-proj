export default class ApiComms {
    async getAllByUrl(url) {
        const resp = await axios(url);
        return resp.data
    }

    async deleteByUrl(url) {
        const resp = await axios.delete(url);
        return resp.status
    }

    async getCount(url){
        try{
            const resp = await axios(url);
            return resp.data;
        }catch(error){
            console.log(error);
        }
    }

    async saveAllByUrl(url,payload)
    {
        try{
            await axios.post(url, payload);
        }catch(error)
        {
            return error;
        }
    }

    async booleanResponse(url, payload){
        try{
            const resp = await axios(url, payload);
            return resp.data;
        }catch(error){
            console.log(error);
        }
    }
}
