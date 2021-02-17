import React from "react";

import Chart from "react-apexcharts";
import ReactDOM from "react-dom";

class MoreHistory extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            series: [{
                name: 'Hours Boots Worn',
                data: []
            }],
            options: {
                title: {
                    text: '',
                    align: 'center',
                },
                chart: {
                    type: 'bar',
                    weight: "100%",
                    height: "100%",
                    background: '#fff'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    title: {
                        text: 'Days'
                    },
                    categories: []
                },
                yaxis: {
                    title: {
                        text: 'Hours'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: [function ({value}) {
                        if (value < 12) {
                            return '#FF0000'
                        } else if (value >= 12 && value < 14) {
                            return '#FFA500'
                        } else {
                            return '#008000'
                        }
                    }]
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " hours"
                        }
                    }
                }
            },
            responsive: [
                {
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            ]
        };
    }

    async componentDidMount() {
        await axios.post(`/timing-history`, {
            start_date: '-2 weeks',
            end_date: '-1 week',
        })
            .then(r => {
                this.setState({
                    series: [{
                        name: 'Hours Boots Worn',
                        data: r.data.hours
                    }],
                    options: {
                        title: {
                            text: r.data.start_date + ' to ' + r.data.end_date,
                        },
                        xaxis: {
                            categories: r.data.days
                        }
                    }
                })
            })
    }

    // note: this only shows two to one week ago currently
    render() {
        return (
            <div className={"text-center mt-4"}>
                {this.state.series[0].data !== undefined && <Chart
                    className={"inline-block md:w-1/3"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                />}
                {this.state.series[0].data === undefined && <p className={"text-red-500"}>No data available for previous weeks</p>}
            </div>
        );
    }
}

export default MoreHistory;

if (document.getElementById('more-history')) {
    ReactDOM.render(<MoreHistory/>, document.getElementById('more-history'));
}
