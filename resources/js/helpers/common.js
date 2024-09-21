export default {
    setup() {
        const customMethod = (id) => {
            return (id + 66);
        }

        //   onMounted(() => {
        //     roleList();
        //   });

        return {
            customMethod,
        }
    }
}
