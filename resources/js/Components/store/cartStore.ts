import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export interface CartItem {
    id: number;
    title: string;
    price: number;
    image: string;
    format: 'Audio' | 'Video' | 'PDF';
    quantity: number;
}

export const useCartStore = defineStore('cart', () => {
    const items = ref<CartItem[]>([]);

    const saveCart = () => {
        localStorage.setItem('cart', JSON.stringify(items.value));
    };
    const loadCart = () => {
        const savedCart = localStorage.getItem('cart');

        if (savedCart) {
            items.value = JSON.parse(savedCart);
        }
    };
    const totalItems = computed(() => items.value.length);

    const totalPrice = computed(() =>
        items.value.reduce((sum, item) => sum + item.price * item.quantity, 0),
    );

    const addItem = (item: Omit<CartItem, 'quantity'>): void => {
        const existingItem = items.value.find((i) => i.id === item.id);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            items.value.push({ ...item, quantity: 1 });
        }

        saveCart();
    };

    const removeItem = (id: number): void => {
        items.value = items.value.filter((item) => item.id !== id);
        saveCart();
    };

    const updateQuantity = (id: number, quantity: number): void => {
        const item = items.value.find((i) => i.id === id);

        if (item && quantity > 0) {
            item.quantity = quantity;
        }

        saveCart();
    };

    const clearCart = (): void => {
        items.value = [];
        saveCart();
    };

    loadCart();

    return {
        items,
        totalItems,
        totalPrice,
        addItem,
        removeItem,
        updateQuantity,
        clearCart,
    };
});
