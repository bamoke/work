export default {
    install:function(Vue){
        Vue.prototype.$formatTableToChart = function(tableData,tableColumn){
            var chartData =[],dimensions=[]

            chartData = tableData.map((item,index)=>{
                var val = Object.values(item)
                return val
            })

            if(tableColumn) {
                dimensions = tableColumn.map((item,index)=>{
                    if(index === 0) return 'product'
                    return item.title
                })
                chartData.unshift(dimensions)
            }
            return chartData
        }
    }
}