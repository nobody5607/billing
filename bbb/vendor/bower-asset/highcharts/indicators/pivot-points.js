/*
 Highstock JS v7.1.3 (2019-08-14)

 Indicator series type for Highstock

 (c) 2010-2019 Pawe Fus

 License: www.highcharts.com/license
*/
(function(c){"object"===typeof module&&module.exports?(c["default"]=c,module.exports=c):"function"===typeof define&&define.amd?define("highcharts/indicators/pivot-points",["highcharts","highcharts/modules/stock"],function(e){c(e);c.Highcharts=e;return c}):c("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(c){function e(c,e,m,p){c.hasOwnProperty(e)||(c[e]=p.apply(null,m))}c=c?c._modules:{};e(c,"indicators/pivot-points.src.js",[c["parts/Globals.js"],c["parts/Utilities.js"]],function(c,
e){function m(a,b){var f=a.series.pointArrayMap,d=f.length;for(n.prototype.pointClass.prototype[b].call(a);d--;)b="dataLabel"+f[d],a[b]&&a[b].element&&a[b].destroy(),a[b]=null}var p=e.defined,r=e.isArray,n=c.seriesTypes.sma;c.seriesType("pivotpoints","sma",{params:{period:28,algorithm:"standard"},marker:{enabled:!1},enableMouseTracking:!1,dataLabels:{enabled:!0,format:"{point.pivotLine}"},dataGrouping:{approximation:"averages"}},{nameBase:"Pivot Points",pointArrayMap:"R4 R3 R2 R1 P S1 S2 S3 S4".split(" "),
pointValKey:"P",toYData:function(a){return[a.P]},translate:function(){var a=this;n.prototype.translate.apply(a);a.points.forEach(function(b){a.pointArrayMap.forEach(function(f){p(b[f])&&(b["plot"+f]=a.yAxis.toPixels(b[f],!0))})});a.plotEndPoint=a.xAxis.toPixels(a.endPoint,!0)},getGraphPath:function(a){for(var b=this,f=a.length,d=[[],[],[],[],[],[],[],[],[]],c=[],e=b.plotEndPoint,k=b.pointArrayMap.length,h,g,l;f--;){g=a[f];for(l=0;l<k;l++)h=b.pointArrayMap[l],p(g[h])&&d[l].push({plotX:g.plotX,plotY:g["plot"+
h],isNull:!1},{plotX:e,plotY:g["plot"+h],isNull:!1},{plotX:e,plotY:null,isNull:!0});e=g.plotX}d.forEach(function(a){c=c.concat(n.prototype.getGraphPath.call(b,a))});return c},drawDataLabels:function(){var a=this,b=a.pointArrayMap,f,d,c;if(a.options.dataLabels.enabled){var e=a.points.length;b.concat([!1]).forEach(function(k,h){for(c=e;c--;)d=a.points[c],k?(d.y=d[k],d.pivotLine=k,d.plotY=d["plot"+k],f=d["dataLabel"+k],h&&(d["dataLabel"+b[h-1]]=d.dataLabel),d.dataLabels||(d.dataLabels=[]),d.dataLabels[0]=
d.dataLabel=f=f&&f.element?f:null):d["dataLabel"+b[h-1]]=d.dataLabel;n.prototype.drawDataLabels.apply(a,arguments)})}},getValues:function(a,b){var c=b.period,d=a.xData,e=(a=a.yData)?a.length:0;b=this[b.algorithm+"Placement"];var m=[],k=[],h=[],g;if(d.length<c||!r(a[0])||4!==a[0].length)return!1;for(g=c+1;g<=e+c;g+=c){var l=d.slice(g-c-1,g);var q=a.slice(g-c-1,g);var p=l.length;var n=l[p-1];q=this.getPivotAndHLC(q);q=b(q);q=m.push([n].concat(q));k.push(n);h.push(m[q-1].slice(1))}this.endPoint=l[0]+
(n-l[0])/p*c;return{values:m,xData:k,yData:h}},getPivotAndHLC:function(a){var b=-Infinity,c=Infinity,d=a[a.length-1][3];a.forEach(function(a){b=Math.max(b,a[1]);c=Math.min(c,a[2])});return[(b+c+d)/3,b,c,d]},standardPlacement:function(a){var b=a[1]-a[2];return[null,null,a[0]+b,2*a[0]-a[2],a[0],2*a[0]-a[1],a[0]-b,null,null]},camarillaPlacement:function(a){var b=a[1]-a[2];return[a[3]+1.5*b,a[3]+1.25*b,a[3]+1.1666*b,a[3]+1.0833*b,a[0],a[3]-1.0833*b,a[3]-1.1666*b,a[3]-1.25*b,a[3]-1.5*b]},fibonacciPlacement:function(a){var b=
a[1]-a[2];return[null,a[0]+b,a[0]+.618*b,a[0]+.382*b,a[0],a[0]-.382*b,a[0]-.618*b,a[0]-b,null]}},{destroyElements:function(){m(this,"destroyElements")},destroy:function(){m(this,"destroyElements")}})});e(c,"masters/indicators/pivot-points.src.js",[],function(){})});
//# sourceMappingURL=pivot-points.js.map