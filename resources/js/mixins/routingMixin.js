import store from '../store/store'


function getResources (routeTo, next) {
    const page = parseInt(routeTo.query.page)
    const limit = parseInt(routeTo.query.limit)
    store
        .dispatch(`${routeTo.meta.module}/list`,{
            limit: routeTo.query.limit,
            page: page
        })
        .then((response) => {
            store
                .dispatch('paginate/setPagination', {
                    total: response.meta.total,
                    page: page,
                    limit: limit
                })
            routeTo.params.page = page
            next()
        })
}
export const RoutingMixin = {
    beforeRouteEnter (routeTo, routeFrom, next) {
        getResources(routeTo, next)
    },
    beforeRouteUpdate (routeTo, routeFrom, next) {
        getResources(routeTo, next)
    },
}