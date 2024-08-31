import { DiffDOMOptions, DiffDOMOptionsPartial, diffType, elementNodeType } from "./types";
import { Diff } from "./helpers";
export { nodeToObj, stringToObj } from "./virtual/index";
export declare class DiffDOM {
    options: DiffDOMOptions;
    constructor(options?: DiffDOMOptionsPartial);
    apply(tree: Element, diffs: (Diff | diffType)[]): boolean;
    undo(tree: Element, diffs: (Diff | diffType)[]): void;
    diff(t1Node: string | elementNodeType | Element, t2Node: string | elementNodeType | Element): Diff[];
}
