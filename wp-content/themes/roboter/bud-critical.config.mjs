//@ts-check

export default config => {
    return {
        src: "http://roboter.loc",
        request: {https: {rejectUnauthorized: false}}
    }

}
