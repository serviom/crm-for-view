<template>
    <div class="mt-3">
        <div class="h3 ml-5 mb-5">Клієнти</div>

        <v-expansion-panels>

            <v-expansion-panel
                v-for="(item, i) in items"
                :key="i"
            >
                <v-expansion-panel-header>
                    <span class="h5 mb-0">{{ item.title }}</span>
                    <template v-slot:actions>
                        <v-icon color="primary">
                            $expand
                        </v-icon>
                    </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <div
                        v-for="(block, ii) in item.blocks"
                        :key="ii"
                    >
                        <div class="text-h6">{{ block.title }}</div>
                        <img :src="block.img" alt="">
                    </div>
                </v-expansion-panel-content>
            </v-expansion-panel>

        </v-expansion-panels>
    </div>
</template>

<script>
export default {
    name: "Help",
    data() {
        return {
            items: [
                {
                    title: 'Як додати клієнта?',
                    blocks: [
                        {
                            title: 'В розділі "Клієнти" натисніть кнопку "Новий клієнт"',
                            img: '/help/clients/clients_help_1.jpg'
                        },
                        {
                            title: 'Далі заповніть усі необхідні поля та натисніть кнопку "Створити"',
                            img: '/help/clients/clients_help_2.jpg'
                        }
                    ]
                },
                {
                    title: 'Як додати угоду?',
                    blocks: [
                        {
                            title: 'В розділі "Клієнти" відкрийте картку потрібного клієнта',
                            img: '/help/clients/clients_help_3.jpg'
                        },
                        {
                            title: 'В картці клієнта натисніть кнопку "Додати угоду"',
                            img: '/help/clients/clients_help_4.jpg'
                        },
                        {
                            title: 'Далі заповніть усі необхідні поля та натисніть кнопку "Зберегти"',
                            img: '/help/clients/clients_help_5.jpg'
                        }
                    ]
                },
                {
                    title: 'Як додати клієнта з угодою?',
                    blocks: [
                        {
                            title: 'В розділі "Клієнти" натисніть кнопку "Новий клієнт"',
                            img: '/help/clients/clients_help_1.jpg'
                        },
                        {
                            title: 'Заповніть усі необхідні поля для клієнта та угоди',
                            img: '/help/clients/clients_help_6.jpg'
                        },
                        {
                            title: 'Натисніть кнопку "Створити"',
                            img: '/help/clients/clients_help_7.jpg'
                        }
                    ]
                },
                {
                    title: 'Коментарі Клієнта',
                    blocks: [
                        {
                            title: 'Коментарі клієнта доступні в картці клієнта і стосуються тільки даного клієнта.',
                            img: '/help/clients/clients_help_9.jpg'
                        },
                        {
                            title: 'В списку кометарів клієнта також присутні згруповані коментарі угод даного клієнта',
                            img: '/help/clients/clients_help_8.jpg'
                        }
                    ]
                },
                {
                    title: 'Коментарі Угоди',
                    blocks: [
                        {
                            title: 'Коментарі угоди доступні в картці угоди, для того щоб відкрити картку угоди, знаходячись в картці клієнта натисніть на потрібну угоду.',
                            img: '/help/clients/clients_help_10.jpg'
                        },
                        {
                            title: 'Коментарі угоди:',
                            img: '/help/clients/clients_help_11.jpg'
                        }
                    ]
                },
                {
                    title: 'Зміна статусу угоди',
                    blocks: [
                        {
                            title: 'Для зручності, угоди мають етапи. Щоб змінити етап відкрийте форму редагування угоди:',
                            img: '/help/clients/clients_help_12.jpg'
                        },
                        {
                            title: 'Етапи угоди:',
                            img: '/help/clients/clients_help_13.jpg'
                        },
                        {
                            title: 'При зміні етапу угоди ви маєте обов\'язково вказати коментар.',
                            img: '/help/clients/clients_help_14.jpg'
                        },
                        {
                            title: 'Щоб клієнт не "загубився" ви будете отримувати нагадування по кожній угоді, дату та час нагадування можна змінити:',
                            img: '/help/clients/clients_help_15.jpg'
                        },
                        {
                            title: 'Зміна дати нагадування при зміні статусу:',
                            img: '/help/clients/clients_help_16.jpg'
                        },
                        {
                            title: 'Зміна часу нагадування при зміні статусу:',
                            img: '/help/clients/clients_help_17.jpg'
                        },
                        {
                            title: 'Для завершення зміни етапу додайте коментар:',
                            img: '/help/clients/clients_help_18.jpg'
                        },
                    ]
                },
                {
                    title: 'Нагадування',
                    blocks: [
                        {
                            title: 'Щоб клієнт не "загубився" ви будете отримувати нагадування по кожній угоді, де ви зможете продовжити поточний етап угоди чи змінити його на інший.',
                            img: '/help/clients/clients_help_19.jpg'
                        },
                        {
                            title: 'Зміна етапу угоди через нагадування:',
                            img: '/help/clients/clients_help_20.jpg'
                        },
                    ]
                },
                {
                    title: 'Запропоновані варіанти',
                    blocks: [
                        {
                            title: 'Запропоновані варіанти доступні в картці угоди:',
                            img: '/help/clients/clients_help_21.jpg'
                        },
                        {
                            title: 'Додати новий варіант для угоди можна натиснувши на відповідну кнопку:',
                            img: '/help/clients/clients_help_22.jpg'
                        },
                        {
                            title: 'У формі, що з\'явилась, додайте посилання на об\'єкт, та натисніть "Додати":',
                            img: '/help/clients/clients_help_23.jpg'
                        },
                        {
                            title: 'Варіанту можна додати коментар:',
                            img: '/help/clients/clients_help_25.jpg'
                        },
                        {
                            title: 'У формі коментаря можна ввести свій текст або вибрати зі швидких варіантів:',
                            img: '/help/clients/clients_help_26.jpg'
                        },
                        {
                            title: 'Варіанти можна архівувати, архівні варіанти відображаються "прозорими" в кінці списку:',
                            img: '/help/clients/clients_help_24.jpg'
                        },
                    ]
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>