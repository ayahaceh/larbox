import { Model } from '@/core/base/model';
import * as Enums from '@/core/base/enums';

export default new Model({
    list: {
        id: {
            type: Enums.valueTypes.text,
        },
        type: {
            value: (context, item) => context.booted.enums.user_notification.types[item.type].label,
            type: Enums.valueTypes.text,
        },
        is_seen: {
            type: Enums.valueTypes.boolean,
        },
        created_at: {
            type: Enums.valueTypes.text,
        },
    },

    filters: {
        id: {
            type: Enums.inputTypes.text,
            attributes: {
                type: 'number',
            },
        },
        type: {
            type: Enums.inputTypes.select,
            options: {
                select: {
                    items: (context) => context.booted.helpers.iterator.get(context.booted.enums.user_notification.types, '*.label'),
                    hasPrompt: true,
                },
            },
        },
        is_seen: {
            type: Enums.inputTypes.select,
            options: {
                select: {
                    items: (context) => {
                        return {
                            0: context.__('Нет'),
                            1: context.__('Да'),
                        };
                    },
                    hasPrompt: true,
                },
            },
        },
    },

    sortings: ['id'],

    show: {
        id: {
            type: Enums.valueTypes.text,
        },
        type: {
            value: (context, item) => context.booted.enums.user_notification.types[item.type].label,
            type: Enums.valueTypes.text,
        },
        is_seen: {
            type: Enums.valueTypes.boolean,
        },
        created_at: {
            type: Enums.valueTypes.text,
        },
        message: {
            type: Enums.valueTypes.text,
        },
    },
});
