/*
  Highcharts JS v7.0.3 (2019-02-06)

 Support for parallel coordinates in Highcharts

 (c) 2010-2019 Pawel Fus

 License: www.highcharts.com/license
*/
(function(e){"object"===typeof module&&module.exports?(e["default"]=e,module.exports=e):"function"===typeof define&&define.amd?define(function(){return e}):e("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(e){(function(b){function e(a){var c=this.series&&this.series.chart,h=a.apply(this,Array.prototype.slice.call(arguments,1)),k,e,d;c&&c.hasParallelCoordinates&&!m(h.formattedValue)&&(d=c.yAxis[this.x],k=d.options,c=(e=q(k.tooltipValueFormat,k.labels.format))?b.format(e,n(this,{value:this.y}),
c.time):d.isDatetimeAxis?c.time.dateFormat(c.time.resolveDTLFormat(k.dateTimeLabelFormats[d.tickPositions.info.unitName]).main,this.y):k.categories?k.categories[this.y]:this.y,h.formattedValue=h.point.formattedValue=c);return h}var r=b.Axis,p=b.Chart,w=p.prototype,t=b.Axis.prototype,f=b.addEvent,q=b.pick,x=b.wrap,l=b.merge,y=b.erase,u=b.splat,n=b.extend,m=b.defined,z=b.arrayMin,A=b.arrayMax,v={lineWidth:0,tickLength:0,opposite:!0,type:"category"};b.setOptions({chart:{parallelCoordinates:!1,parallelAxes:{lineWidth:1,
title:{text:"",reserveSpace:!1},labels:{x:0,y:4,align:"center",reserveSpace:!1},offset:0}}});f(p,"init",function(a){a=a.args[0];var c=u(a.yAxis||{}),h=c.length,b=[];if(this.hasParallelCoordinates=a.chart&&a.chart.parallelCoordinates){for(this.setParallelInfo(a);h<=this.parallelInfo.counter;h++)b.push({});a.legend||(a.legend={});void 0===a.legend.enabled&&(a.legend.enabled=!1);l(!0,a,{boost:{seriesThreshold:Number.MAX_VALUE},plotOptions:{series:{boostThreshold:Number.MAX_VALUE}}});a.yAxis=c.concat(b);
a.xAxis=l(v,u(a.xAxis||{})[0])}});f(p,"update",function(a){a=a.options;a.chart&&(m(a.chart.parallelCoordinates)&&(this.hasParallelCoordinates=a.chart.parallelCoordinates),this.hasParallelCoordinates&&a.chart.parallelAxes&&(this.options.chart.parallelAxes=l(this.options.chart.parallelAxes,a.chart.parallelAxes),this.yAxis.forEach(function(a){a.update({},!1)})))});n(w,{setParallelInfo:function(a){var c=this;a=a.series;c.parallelInfo={counter:0};a.forEach(function(a){a.data&&(c.parallelInfo.counter=Math.max(c.parallelInfo.counter,
a.data.length-1))})}});t.keepProps.push("parallelPosition");f(r,"afterSetOptions",function(a){var c=this.chart,b=["left","width","height","top"];c.hasParallelCoordinates&&(c.inverted&&(b=b.reverse()),this.isXAxis?this.options=l(this.options,v,a.userOptions):(this.options=l(this.options,this.chart.options.chart.parallelAxes,a.userOptions),this.parallelPosition=q(this.parallelPosition,c.yAxis.length),this.setParallelPosition(b,this.options)))});f(r,"getSeriesExtremes",function(a){if(this.chart&&this.chart.hasParallelCoordinates&&
!this.isXAxis){var c=this.parallelPosition,b=[];this.series.forEach(function(a){a.visible&&m(a.yData[c])&&b.push(a.yData[c])});this.dataMin=z(b);this.dataMax=A(b);a.preventDefault()}});n(t,{setParallelPosition:function(a,c){var b=(this.parallelPosition+.5)/(this.chart.parallelInfo.counter+1);this.chart.polar?c.angle=360*b:(c[a[0]]=100*b+"%",this[a[1]]=c[a[1]]=0,this[a[2]]=c[a[2]]=null,this[a[3]]=c[a[3]]=null)}});f(b.Series,"bindAxes",function(a){if(this.chart.hasParallelCoordinates){var c=this;this.chart.axes.forEach(function(a){c.insert(a.series);
a.isDirty=!0});c.xAxis=this.chart.xAxis[0];c.yAxis=this.chart.yAxis[0];a.preventDefault()}});f(b.Series,"afterTranslate",function(){var a=this.chart,c=this.points,b=c&&c.length,e=Number.MAX_VALUE,f,d,g;if(this.chart.hasParallelCoordinates){for(g=0;g<b;g++)d=c[g],m(d.y)?(d.plotX=a.polar?a.yAxis[g].angleRad||0:a.inverted?a.plotHeight-a.yAxis[g].top+a.plotTop:a.yAxis[g].left-a.plotLeft,d.clientX=d.plotX,d.plotY=a.yAxis[g].translate(d.y,!1,!0,null,!0),void 0!==f&&(e=Math.min(e,Math.abs(d.plotX-f))),f=
d.plotX,d.isInside=a.isInsidePlot(d.plotX,d.plotY,a.inverted)):d.isNull=!0;this.closestPointRangePx=e}},{order:1});b.addEvent(b.Series,"destroy",function(){this.chart.hasParallelCoordinates&&(this.chart.axes||[]).forEach(function(a){a&&a.series&&(y(a.series,this),a.isDirty=a.forceRedraw=!0)},this)});["line","spline"].forEach(function(a){x(b.seriesTypes[a].prototype.pointClass.prototype,"getLabelConfig",e)})})(e)});
//# sourceMappingURL=parallel-coordinates.js.map
