import { elementNodeType } from "./types";
export declare class Diff {
    constructor(options?: {});
    toString(): string;
    setValue(aKey: string | number, aValue: string | number | boolean | number[] | {
        [key: string]: string | {
            [key: string]: string;
        };
    } | elementNodeType): this;
}
export declare function checkElementType(element: any, ...elementTypeNames: string[]): boolean;
