import bacterium from '../../../../images/marker-icons/bacterium.svg'
import bug from '../../../../images/marker-icons/bug.svg'
import empty from '../../../../images/marker-icons/empty.svg'
import fishfin from '../../../../images/marker-icons/fishfin.svg'
import globe from '../../../../images/marker-icons/globe.svg'
import mushroom from '../../../../images/marker-icons/mushroom.svg'
import tree from '../../../../images/marker-icons/tree.svg'
import water from '../../../../images/marker-icons/water.svg'
import weather from '../../../../images/marker-icons/weather.svg'

const markersIcons = [
  {
    code: 'biota-vertebrados',
    icon: fishfin,
    backgroundColor: '#DC343A',
    color: '#FFFFFF',
    faStyle: 'fish-fins',
  },
  {
    code: 'biota-invertebrados',
    icon: bug,
    backgroundColor: '#8834DC',
    color: '#FFFFFF',
    faStyle: 'bug',
  },
  {
    code: 'biota-protistas',
    icon: bacterium,
    backgroundColor: '#A5A5A5',
    color: '#000000',
    faStyle: 'bacterium',
  },
  {
    code: 'biota-hongos',
    icon: mushroom,
    backgroundColor: '#000000',
    color: '#FFFFFF',
    faStyle: 'virus',
  },
  {
    code: 'biota-plantas',
    icon: tree,
    backgroundColor: '#56AA4D',
    color: '#000000',
    faStyle: 'tree',
  },
  {
    code: 'clima-y-meteorologia-estaciones-metoeorologicas',
    icon: weather,
    backgroundColor: '#1c248c',
    color: '#FFFFFF',
    faStyle: 'cloud-sun',
  },
  {
    code: 'geografia-fisica-geomorfologia',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'geografia-fisica-edafologia',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'geografia-fisica-vulcanismo-y-sismicidad',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'geografia-fisica-glaciologia',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'geografia-fisica-geologia',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'geografia-fisica-degradacion-del-medio-y-desertificacion',
    icon: globe,
    backgroundColor: '#BCA460',
    color: '#000000',
    faStyle: 'globe',
  },
  {
    code: 'hidrografia-aguas-continentales',
    icon: water,
    backgroundColor: '#3490DC',
    color: '#000000',
    faStyle: 'water',
  },
  {
    code: 'hidrografia-aguas-subterraneas',
    icon: water,
    backgroundColor: '#3490DC',
    color: '#000000',
    faStyle: 'water',
  },
]

const defaultMarkerIcon = {
  code: 'default',
  icon: empty,
  backgroundColor: '#e26d1e',
  color: '#000000',
  faStyle: 'circle-question',
}

const markerStyles = {
  styles: markersIcons,
  find (code) {
    return this.styles.find((element) => element.code === code) || defaultMarkerIcon
  },
}

export {
  markersIcons,
  defaultMarkerIcon,
  markerStyles,
}
