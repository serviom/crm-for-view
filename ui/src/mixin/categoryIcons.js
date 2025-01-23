let categoryIcons = {
    methods: {
        catIcon(cat) {
            switch (cat) {
                case 'Квартира':
                    return 'mdi-home-city-outline'
                case 'Будинок':
                    return 'mdi-home-outline'
                case 'Котедж':
                    return 'mdi-home-modern'
                case 'Дача':
                    return 'mdi-tree-outline'
                case 'Ділянка':
                    return 'mdi-vector-square'
                case 'Комерція':
                    return 'mdi-hospital-building'
                default:
                    return 'mdi-hexagon-multiple'
            }
        },
    }
}

export default categoryIcons;